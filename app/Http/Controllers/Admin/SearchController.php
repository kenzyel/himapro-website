<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Departemen;
use App\Models\Dokumen;
use App\Models\Notulensi;
use App\Models\Partner;
use App\Models\Pengumuman;
use App\Models\Pengurus;
use App\Models\ProgramKerja;
use App\Models\Surat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected const LIMIT = 5;

    /**
     * Endpoint AJAX search.
     */
    public function search(Request $request): JsonResponse
    {
        $q = trim((string) $request->input('q', ''));

        if (strlen($q) < 2) {
            return response()->json([
                'query' => $q,
                'total' => 0,
                'results' => [],
            ]);
        }

        $user = auth()->user();
        $can = fn ($permission) => $user && $user->hasPermission($permission);

        $results = [];

        /*
        |--------------------------------------------------------------------------
        | PENGURUS
        |--------------------------------------------------------------------------
        */
        if ($can('pengurus.view')) {
            $items = Pengurus::where(function ($query) use ($q) {
                    $query->where('nama', 'like', "%{$q}%")
                        ->orWhere('jabatan', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                })
                ->orderBy('urutan')
                ->limit(self::LIMIT)
                ->get();

            if ($items->count() > 0) {
                $results[] = [
                    'module' => 'Pengurus',
                    'icon' => 'bi-people-fill',
                    'color' => 'primary',
                    'items' => $items->map(fn ($item) => [
                        'title' => $item->nama,
                        'subtitle' => $item->jabatan,
                        'url' => route('admin.pengurus.show', $item),
                    ])->toArray(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DEPARTEMEN
        |--------------------------------------------------------------------------
        */
        if ($can('departemen.view')) {
            $items = Departemen::where(function ($query) use ($q) {
                    $query->where('nama', 'like', "%{$q}%")
                        ->orWhere('kode', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%");
                })
                ->orderBy('urutan')
                ->limit(self::LIMIT)
                ->get();

            if ($items->count() > 0) {
                $results[] = [
                    'module' => 'Departemen',
                    'icon' => 'bi-diagram-3-fill',
                    'color' => 'blue',
                    'items' => $items->map(fn ($item) => [
                        'title' => $item->nama,
                        'subtitle' => 'Kode: ' . $item->kode,
                        'url' => route('admin.departemen.show', $item),
                    ])->toArray(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PROGRAM KERJA
        |--------------------------------------------------------------------------
        */
        if ($can('program-kerja.view')) {
            $items = ProgramKerja::where(function ($query) use ($q) {
                    $query->where('nama', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%")
                        ->orWhere('periode', 'like', "%{$q}%");
                })
                ->limit(self::LIMIT)
                ->get();

            if ($items->count() > 0) {
                $results[] = [
                    'module' => 'Program Kerja',
                    'icon' => 'bi-kanban-fill',
                    'color' => 'purple',
                    'items' => $items->map(fn ($item) => [
                        'title' => $item->nama,
                        'subtitle' => 'Periode ' . $item->periode,
                        'url' => route('admin.program-kerja.show', $item),
                    ])->toArray(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | AGENDA
        |--------------------------------------------------------------------------
        */
        if ($can('agenda.view')) {
            $items = Agenda::where(function ($query) use ($q) {
                    $query->where('judul', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%")
                        ->orWhere('lokasi', 'like', "%{$q}%");
                })
                ->orderByDesc('tanggal_mulai')
                ->limit(self::LIMIT)
                ->get();

            if ($items->count() > 0) {
                $results[] = [
                    'module' => 'Agenda',
                    'icon' => 'bi-calendar-event-fill',
                    'color' => 'orange',
                    'items' => $items->map(fn ($item) => [
                        'title' => $item->judul,
                        'subtitle' => $item->lokasi ?: ($item->tanggal_mulai?->format('d M Y') ?? ''),
                        'url' => route('admin.agenda.show', $item),
                    ])->toArray(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PENGUMUMAN
        |--------------------------------------------------------------------------
        */
        if ($can('pengumuman.view')) {
            $items = Pengumuman::where(function ($query) use ($q) {
                    $query->where('judul', 'like', "%{$q}%")
                        ->orWhere('isi', 'like', "%{$q}%")
                        ->orWhere('ringkasan', 'like', "%{$q}%");
                })
                ->orderByDesc('created_at')
                ->limit(self::LIMIT)
                ->get();

            if ($items->count() > 0) {
                $results[] = [
                    'module' => 'Pengumuman',
                    'icon' => 'bi-megaphone-fill',
                    'color' => 'green',
                    'items' => $items->map(fn ($item) => [
                        'title' => $item->judul,
                        'subtitle' => $item->created_at?->format('d M Y') ?? '',
                        'url' => route('admin.pengumuman.show', $item),
                    ])->toArray(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | PARTNER
        |--------------------------------------------------------------------------
        */
        if ($can('partner.view')) {
            $items = Partner::where(function ($query) use ($q) {
                    $query->where('nama', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%");
                })
                ->orderBy('urutan')
                ->limit(self::LIMIT)
                ->get();

            if ($items->count() > 0) {
                $results[] = [
                    'module' => 'Partner',
                    'icon' => 'bi-briefcase-fill',
                    'color' => 'pink',
                    'items' => $items->map(fn ($item) => [
                        'title' => $item->nama,
                        'subtitle' => $item->website ?: 'Partner',
                        'url' => route('admin.partner.show', $item),
                    ])->toArray(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | DOKUMEN
        |--------------------------------------------------------------------------
        */
        if ($can('dokumen.view')) {
            $items = Dokumen::where(function ($query) use ($q) {
                    $query->where('nama', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%")
                        ->orWhere('file_name', 'like', "%{$q}%");
                })
                ->orderByDesc('created_at')
                ->limit(self::LIMIT)
                ->get();

            if ($items->count() > 0) {
                $results[] = [
                    'module' => 'Dokumen',
                    'icon' => 'bi-folder-fill',
                    'color' => 'teal',
                    'items' => $items->map(fn ($item) => [
                        'title' => $item->nama,
                        'subtitle' => $item->file_name,
                        'url' => route('admin.dokumen.show', $item),
                    ])->toArray(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SURAT
        |--------------------------------------------------------------------------
        */
        if ($can('surat.view')) {
            $items = Surat::where(function ($query) use ($q) {
                    $query->where('nomor_surat', 'like', "%{$q}%")
                        ->orWhere('perihal', 'like', "%{$q}%")
                        ->orWhere('pengirim', 'like', "%{$q}%")
                        ->orWhere('penerima', 'like', "%{$q}%");
                })
                ->orderByDesc('tanggal_surat')
                ->limit(self::LIMIT)
                ->get();

            if ($items->count() > 0) {
                $results[] = [
                    'module' => 'Surat',
                    'icon' => 'bi-envelope-fill',
                    'color' => 'red',
                    'items' => $items->map(fn ($item) => [
                        'title' => $item->nomor_surat,
                        'subtitle' => $item->perihal,
                        'url' => route('admin.surat.show', $item),
                    ])->toArray(),
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | NOTULENSI
        |--------------------------------------------------------------------------
        */
        if ($can('notulensi.view')) {
            $items = Notulensi::where(function ($query) use ($q) {
                    $query->where('judul', 'like', "%{$q}%")
                        ->orWhere('agenda', 'like', "%{$q}%")
                        ->orWhere('tempat', 'like', "%{$q}%");
                })
                ->orderByDesc('tanggal')
                ->limit(self::LIMIT)
                ->get();

            if ($items->count() > 0) {
                $results[] = [
                    'module' => 'Notulensi',
                    'icon' => 'bi-journal-text',
                    'color' => 'primary',
                    'items' => $items->map(fn ($item) => [
                        'title' => $item->judul,
                        'subtitle' => $item->tanggal?->format('d M Y') ?? '',
                        'url' => route('admin.notulensi.show', $item),
                    ])->toArray(),
                ];
            }
        }

        $total = collect($results)->sum(fn ($group) => count($group['items']));

        return response()->json([
            'query' => $q,
            'total' => $total,
            'results' => $results,
        ]);
    }
}