<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Nama module yang di-log.
     */
    protected const MODULE_MAP = [
        'App\Models\Pengurus' => 'pengurus',
        'App\Models\Departemen' => 'departemen',
        'App\Models\ProgramKerja' => 'program-kerja',
        'App\Models\Agenda' => 'agenda',
        'App\Models\Pengumuman' => 'pengumuman',
        'App\Models\Gallery' => 'gallery',
        'App\Models\GalleryItem' => 'gallery-item',
        'App\Models\Partner' => 'partner',
        'App\Models\Pesan' => 'pesan',
        'App\Models\Notulensi' => 'notulensi',
        'App\Models\Dokumen' => 'dokumen',
        'App\Models\Surat' => 'surat',
        'App\Models\Anggaran' => 'anggaran',
        'App\Models\Keuangan' => 'keuangan',
        'App\Models\User' => 'user',
        'App\Models\Role' => 'role',
        'App\Models\Setting' => 'setting',
    ];

    /**
     * Field yang tidak perlu dicatat.
     */
    protected const HIDDEN_FIELDS = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Catat aktivitas create.
     */
    public static function logCreated(Model $model): void
    {
        self::record(
            action: 'created',
            model: $model,
            description: self::describeAction('created', $model),
            oldValues: null,
            newValues: self::filterFields($model->getAttributes())
        );
    }

    /**
     * Catat aktivitas update.
     */
    public static function logUpdated(Model $model): void
    {
        $changes = $model->getChanges();
        $original = $model->getOriginal();

        // Skip kalau tidak ada perubahan meaningful
        $changes = self::filterFields($changes);
        if (empty($changes)) {
            return;
        }

        $oldValues = [];
        foreach (array_keys($changes) as $key) {
            $oldValues[$key] = $original[$key] ?? null;
        }

        self::record(
            action: 'updated',
            model: $model,
            description: self::describeAction('updated', $model),
            oldValues: $oldValues,
            newValues: $changes
        );
    }

    /**
     * Catat aktivitas delete.
     */
    public static function logDeleted(Model $model): void
    {
        self::record(
            action: 'deleted',
            model: $model,
            description: self::describeAction('deleted', $model),
            oldValues: self::filterFields($model->getOriginal()),
            newValues: null
        );
    }

    /**
     * Log generic (untuk custom action).
     */
    public static function log(
        string $action,
        ?Model $model = null,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null,
        ?string $module = null
    ): void {
        self::record(
            action: $action,
            model: $model,
            description: $description ?? $action,
            oldValues: $oldValues,
            newValues: $newValues,
            module: $module
        );
    }

    /**
     * Record ke database.
     */
    protected static function record(
        string $action,
        ?Model $model,
        string $description,
        ?array $oldValues,
        ?array $newValues,
        ?string $module = null
    ): void {
        try {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'module' => $module ?? self::resolveModule($model),
                'description' => $description,
                'subject_type' => $model ? get_class($model) : null,
                'subject_id' => $model?->getKey(),
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // Jangan sampai log gagal dan break aplikasi
            \Log::error('ActivityLog failed: ' . $e->getMessage());
        }
    }

    /**
     * Resolve module name dari model.
     */
    protected static function resolveModule(?Model $model): ?string
    {
        if (! $model) {
            return null;
        }

        $class = get_class($model);

        return self::MODULE_MAP[$class] ?? strtolower(class_basename($model));
    }

    /**
     * Filter field yang tidak perlu dicatat.
     */
    protected static function filterFields(array $fields): array
    {
        return array_filter(
            $fields,
            fn ($key) => ! in_array($key, self::HIDDEN_FIELDS, true),
            ARRAY_FILTER_USE_KEY
        );
    }

    /**
     * Buat deskripsi otomatis dari model.
     */
    protected static function describeAction(string $action, Model $model): string
    {
        $label = self::resolveLabel($model);
        $actionLabel = match ($action) {
            'created' => 'Menambahkan',
            'updated' => 'Memperbarui',
            'deleted' => 'Menghapus',
            default => ucfirst($action),
        };

        return "{$actionLabel} {$label}";
    }

    /**
     * Ambil label yang mudah dibaca dari model.
     */
    protected static function resolveLabel(Model $model): string
    {
        // Coba kolom yang umum
        foreach (['nama', 'judul', 'name', 'nomor_surat', 'deskripsi', 'key'] as $field) {
            if (! empty($model->$field)) {
                return class_basename($model) . ': ' . \Str::limit((string) $model->$field, 60);
            }
        }

        return class_basename($model) . ' #' . $model->getKey();
    }
}