<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Anggaran;
use App\Models\Departemen;
use App\Models\Keuangan;
use App\Models\Pesan;
use App\Models\Pengurus;
use App\Models\ProgramKerja;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        $can = fn($permission) => $user && $user->hasPermission($permission);

        /*
        |--------------------------------------------------------------------------
        | STATISTIK UTAMA — selalu di-query (semua user punya dashboard.view)
        |--------------------------------------------------------------------------
        */

        $totalPengurus = Pengurus::where('status', 'active')->count();
        $totalDepartemen = Departemen::where('status', 'active')->count();
        $totalProgramKerja = ProgramKerja::count();
        $totalAgenda = Agenda::where('is_public', true)->count();

        /*
        |--------------------------------------------------------------------------
        | DEFAULT VALUES — biar view tidak error kalau variable tidak di-query
        |--------------------------------------------------------------------------
        */

        // Keuangan chart
        $bulanLabels = [];
        $bulanPemasukan = [];
        $bulanPengeluaran = [];

        // Program kerja chart
        $programKerjaStatus = [
            'planned' => 0,
            'ongoing' => 0,
            'completed' => 0,
            'cancelled' => 0,
        ];

        // Agenda chart
        $agendaLabels = [];
        $agendaData = [];

        // Anggaran chart
        $anggaranStatus = [
            'draft' => 0,
            'approved' => 0,
            'realized' => 0,
            'cancelled' => 0,
        ];

        // Ringkasan keuangan
        $totalPemasukan = 0;
        $totalPengeluaran = 0;
        $saldo = 0;

        // Pesan
        $pesanUnread = 0;

        /*
        |--------------------------------------------------------------------------
        | KEUANGAN — Tren 6 Bulan (hanya kalau user punya akses)
        |--------------------------------------------------------------------------
        */

        if ($can('keuangan.view') || $can('anggaran.view') || $can('laporan.view')) {

            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $bulanLabels[] = $date->translatedFormat('M Y');

                $pemasukan = Keuangan::where('jenis', 'pemasukan')
                    ->where('status', 'approved')
                    ->whereYear('tanggal', $date->year)
                    ->whereMonth('tanggal', $date->month)
                    ->sum('jumlah');

                $pengeluaran = Keuangan::where('jenis', 'pengeluaran')
                    ->where('status', 'approved')
                    ->whereYear('tanggal', $date->year)
                    ->whereMonth('tanggal', $date->month)
                    ->sum('jumlah');

                $bulanPemasukan[] = (float) $pemasukan;
                $bulanPengeluaran[] = (float) $pengeluaran;
            }

            $totalPemasukan = Keuangan::where('jenis', 'pemasukan')
                ->where('status', 'approved')
                ->sum('jumlah');

            $totalPengeluaran = Keuangan::where('jenis', 'pengeluaran')
                ->where('status', 'approved')
                ->sum('jumlah');

            $saldo = $totalPemasukan - $totalPengeluaran;
        }

        /*
        |--------------------------------------------------------------------------
        | PROGRAM KERJA — Distribusi Status (hanya kalau punya akses)
        |--------------------------------------------------------------------------
        */

        if ($can('program-kerja.view')) {
            $programKerjaStatus = [
                'planned' => ProgramKerja::where('status', 'planned')->count(),
                'ongoing' => ProgramKerja::where('status', 'ongoing')->count(),
                'completed' => ProgramKerja::where('status', 'completed')->count(),
                'cancelled' => ProgramKerja::where('status', 'cancelled')->count(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | AGENDA — 6 Bulan Terakhir (hanya kalau punya akses)
        |--------------------------------------------------------------------------
        */

        if ($can('agenda.view')) {
            for ($i = 5; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $agendaLabels[] = $date->translatedFormat('M');

                $count = Agenda::whereYear('tanggal_mulai', $date->year)
                    ->whereMonth('tanggal_mulai', $date->month)
                    ->count();

                $agendaData[] = $count;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | ANGGARAN — Distribusi Status (hanya kalau punya akses)
        |--------------------------------------------------------------------------
        */

        if ($can('anggaran.view')) {
            $anggaranStatus = [
                'draft' => Anggaran::where('status', 'draft')->count(),
                'approved' => Anggaran::where('status', 'approved')->count(),
                'realized' => Anggaran::where('status', 'realized')->count(),
                'cancelled' => Anggaran::where('status', 'cancelled')->count(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | PESAN — Belum Dibaca (hanya kalau punya akses)
        |--------------------------------------------------------------------------
        */

        if ($can('pesan.view')) {
            $pesanUnread = Pesan::where('status', 'unread')->count();
        }

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard.index', [
            'user' => $user,

            // Statistik utama
            'totalPengurus' => $totalPengurus,
            'totalDepartemen' => $totalDepartemen,
            'totalProgramKerja' => $totalProgramKerja,
            'totalAgenda' => $totalAgenda,

            // Keuangan chart
            'bulanLabels' => $bulanLabels,
            'bulanPemasukan' => $bulanPemasukan,
            'bulanPengeluaran' => $bulanPengeluaran,

            // Program kerja chart
            'programKerjaStatus' => $programKerjaStatus,

            // Agenda chart
            'agendaLabels' => $agendaLabels,
            'agendaData' => $agendaData,

            // Anggaran chart
            'anggaranStatus' => $anggaranStatus,

            // Ringkasan keuangan
            'totalPemasukan' => $totalPemasukan,
            'totalPengeluaran' => $totalPengeluaran,
            'saldo' => $saldo,

            // Pesan
            'pesanUnread' => $pesanUnread,
        ]);
    }
}