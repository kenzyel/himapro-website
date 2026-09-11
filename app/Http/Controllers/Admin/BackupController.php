<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BackupController extends Controller
{
    /**
     * Folder penyimpanan backup (relative ke storage/app/).
     */
    protected const BACKUP_FOLDER = 'backups';

    /**
     * Batas maksimal file backup yang disimpan.
     */
    protected const MAX_BACKUPS = 10;

    /**
     * Daftar backup yang ada.
     */
    public function index(): View
    {
        $backups = $this->getBackupList();

        $stats = [
            'total' => count($backups),
            'total_size' => collect($backups)->sum('size'),
            'latest' => $backups[0]['created_at'] ?? null,
        ];

        return view('admin.backup.index', compact('backups', 'stats'));
    }

    /**
     * Buat backup baru.
     */
    public function create(): RedirectResponse
    {
        try {
            $filename = 'backup-himapro-' . now()->format('Y-m-d-His') . '.sql';
            $path = self::BACKUP_FOLDER . '/' . $filename;

            $fullPath = storage_path('app/' . $path);

            // Pastikan folder ada
            if (! is_dir(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            // Coba mysqldump dulu
            if ($this->hasMysqldump()) {
                $success = $this->backupWithMysqldump($fullPath);
            } else {
                $success = $this->backupWithPhp($fullPath);
            }

            if (! $success || ! file_exists($fullPath)) {
                return back()->with('error', 'Gagal membuat backup. Cek log untuk detail.');
            }

            // Hapus backup lama kalau lebih dari batas
            $this->cleanOldBackups();

            return redirect()
                ->route('admin.backup.index')
                ->with('success', 'Backup berhasil dibuat: ' . $filename);

        } catch (\Throwable $e) {
            \Log::error('Backup error: ' . $e->getMessage());

            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Download backup.
     */
    public function download(string $filename): BinaryFileResponse|RedirectResponse
    {
        $filename = basename($filename);
        $path = storage_path('app/' . self::BACKUP_FOLDER . '/' . $filename);

        if (! file_exists($path)) {
            return back()->with('error', 'File backup tidak ditemukan.');
        }

        return response()->download($path, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    /**
     * Hapus backup.
     */
    public function destroy(string $filename): RedirectResponse
    {
        $filename = basename($filename);
        $path = self::BACKUP_FOLDER . '/' . $filename;

        if (! Storage::exists($path)) {
            return back()->with('error', 'File backup tidak ditemukan.');
        }

        Storage::delete($path);

        return back()->with('success', 'Backup "' . $filename . '" berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    /**
     * Get list of backups.
     */
    protected function getBackupList(): array
    {
        $folder = storage_path('app/' . self::BACKUP_FOLDER);

        if (! is_dir($folder)) {
            return [];
        }

        $files = glob($folder . '/*.sql');

        if (! $files) {
            return [];
        }

        $backups = [];

        foreach ($files as $file) {
            $backups[] = [
                'filename' => basename($file),
                'size' => filesize($file),
                'created_at' => filemtime($file),
            ];
        }

        // Urutkan dari terbaru
        usort($backups, fn ($a, $b) => $b['created_at'] <=> $a['created_at']);

        return $backups;
    }

    /**
     * Cek apakah mysqldump tersedia.
     */
    protected function hasMysqldump(): bool
    {
        // Coba cek via exec
        $check = @shell_exec('which mysqldump 2>&1');

        if ($check && str_contains($check, 'mysqldump')) {
            return true;
        }

        // Windows: coba where
        $check = @shell_exec('where mysqldump 2>&1');

        return $check && str_contains($check, 'mysqldump');
    }

    /**
     * Backup pakai mysqldump.
     */
    protected function backupWithMysqldump(string $fullPath): bool
    {
        $db = config('database.connections.mysql');

        $host = $db['host'] ?? '127.0.0.1';
        $port = $db['port'] ?? '3306';
        $database = $db['database'];
        $username = $db['username'];
        $password = $db['password'] ?? '';

        // Build command
        $passwordPart = $password !== '' ? '-p' . escapeshellarg($password) : '';

        $command = sprintf(
            'mysqldump --host=%s --port=%s --user=%s %s --single-transaction --routines --triggers %s > %s 2>&1',
            escapeshellarg($host),
            escapeshellarg($port),
            escapeshellarg($username),
            $passwordPart,
            escapeshellarg($database),
            escapeshellarg($fullPath)
        );

        // Windows: pakai cmd
        if (PHP_OS_FAMILY === 'Windows') {
            $command = 'cmd /c "' . $command . '"';
        }

        @exec($command, $output, $returnCode);

        return $returnCode === 0 && file_exists($fullPath) && filesize($fullPath) > 0;
    }

    /**
     * Backup pakai PHP murni (fallback).
     */
    protected function backupWithPhp(string $fullPath): bool
    {
        try {
            $handle = fopen($fullPath, 'w');

            if (! $handle) {
                return false;
            }

            // Header
            fwrite($handle, "-- HIMAPRO TI SAKTI Database Backup\n");
            fwrite($handle, "-- Generated: " . now()->format('Y-m-d H:i:s') . "\n");
            fwrite($handle, "-- Database: " . config('database.connections.mysql.database') . "\n\n");

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n");
            fwrite($handle, "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';\n\n");

            // Ambil semua tabel
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.mysql.database');
            $key = 'Tables_in_' . $dbName;

            foreach ($tables as $table) {
                $tableName = $table->$key ?? array_values((array) $table)[0];

                fwrite($handle, "\n-- -------- Table: {$tableName} --------\n");
                fwrite($handle, "DROP TABLE IF EXISTS `{$tableName}`;\n");

                // Create table
                $create = DB::select("SHOW CREATE TABLE `{$tableName}`");
                if (! empty($create)) {
                    $createSql = array_values((array) $create[0])[1];
                    fwrite($handle, $createSql . ";\n\n");
                }

                // Data
                $rows = DB::table($tableName)->get();

                foreach ($rows as $row) {
                    $rowArray = (array) $row;

                    $columns = array_map(fn ($col) => "`{$col}`", array_keys($rowArray));
                    $values = array_map(function ($val) {
                        if (is_null($val)) return 'NULL';
                        return "'" . addslashes((string) $val) . "'";
                    }, array_values($rowArray));

                    fwrite($handle, "INSERT INTO `{$tableName}` (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $values) . ");\n");
                }

                fwrite($handle, "\n");
            }

            fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");

            fclose($handle);

            return true;

        } catch (\Throwable $e) {
            \Log::error('PHP backup failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Hapus backup lama kalau lebih dari batas.
     */
    protected function cleanOldBackups(): void
    {
        $backups = $this->getBackupList();

        if (count($backups) <= self::MAX_BACKUPS) {
            return;
        }

        // Ambil yang berlebih (index mulai MAX_BACKUPS)
        $toDelete = array_slice($backups, self::MAX_BACKUPS);

        foreach ($toDelete as $backup) {
            Storage::delete(self::BACKUP_FOLDER . '/' . $backup['filename']);
        }
    }
}