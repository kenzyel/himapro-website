@extends('layouts.admin')

@section('title', 'Laporan Program Kerja')

@section('content')

<a href="{{ route('admin.laporan.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Laporan
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>Laporan Program Kerja</h1>
        <p>Rekap program kerja HIMAPRO TI SAKTI.</p>
    </div>

    <button onclick="window.print()" class="btn-himapro btn-himapro-secondary no-print">
        <i class="bi bi-printer"></i>
        Cetak
    </button>
</div>


{{-- FILTER --}}
<div class="filter-card no-print" data-aos="fade-up">
    <form method="GET">
        <div class="row g-2">

            <div class="col-lg-4 col-md-6">
                <label class="form-label">Periode</label>
                <select name="periode" class="form-select">
                    <option value="">Semua Periode</option>
                    @foreach ($periodes as $p)
                        <option value="{{ $p }}" @selected($periode === $p)>{{ $p }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-3 col-md-6">
                <label class="form-label">Departemen</label>
                <select name="departemen_id" class="form-select">
                    <option value="">Semua Departemen</option>
                    @foreach ($departemens as $dep)
                        <option value="{{ $dep->id }}" @selected($departemenId == $dep->id)>
                            {{ $dep->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-lg-3 col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="planned" @selected($status === 'planned')>Direncanakan</option>
                    <option value="ongoing" @selected($status === 'ongoing')>Berjalan</option>
                    <option value="completed" @selected($status === 'completed')>Selesai</option>
                    <option value="cancelled" @selected($status === 'cancelled')>Dibatalkan</option>
                </select>
            </div>

            <div class="col-lg-2 col-md-6 d-flex gap-2 align-items-end">
                <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                    <i class="bi bi-funnel-fill"></i>
                    Filter
                </button>

                @if ($periode || $departemenId || $status)
                    <a href="{{ route('admin.laporan.program-kerja') }}" class="btn-icon" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>
</div>


{{-- SUMMARY --}}
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-lg-2 col-md-4">
        <div class="stat-card">
            <div class="stat-label" style="margin-bottom: 6px;">Total</div>
            <div class="stat-value" style="font-size: 26px;">{{ $summary['total'] }}</div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4">
        <div class="stat-card">
            <div class="stat-label" style="margin-bottom: 6px;">Direncanakan</div>
            <div class="stat-value" style="font-size: 26px; color: var(--primary);">{{ $summary['planned'] }}</div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4">
        <div class="stat-card">
            <div class="stat-label" style="margin-bottom: 6px;">Berjalan</div>
            <div class="stat-value" style="font-size: 26px; color: #93c5fd;">{{ $summary['ongoing'] }}</div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4">
        <div class="stat-card">
            <div class="stat-label" style="margin-bottom: 6px;">Selesai</div>
            <div class="stat-value" style="font-size: 26px; color: #86efac;">{{ $summary['completed'] }}</div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4">
        <div class="stat-card">
            <div class="stat-label" style="margin-bottom: 6px;">Dibatalkan</div>
            <div class="stat-value" style="font-size: 26px; color: #fca5a5;">{{ $summary['cancelled'] }}</div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4">
        <div class="stat-card">
            <div class="stat-label" style="margin-bottom: 6px;">Total Anggaran</div>
            <div class="stat-value" style="font-size: 14px; color: var(--primary);">
                Rp {{ number_format($summary['total_anggaran'], 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>


{{-- TABLE --}}
<div class="admin-card" data-aos="fade-up" data-aos-delay="100">

    <div class="card-header">
        <h2 class="admin-card-title">Detail Program Kerja</h2>
        <p class="card-subtitle">{{ $summary['total'] }} program kerja ditampilkan</p>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="px-4" width="60">#</th>
                        <th>Program Kerja</th>
                        <th>Departemen</th>
                        <th>Periode</th>
                        <th>Tanggal</th>
                        <th class="text-end">Anggaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programKerjas as $index => $pk)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $index + 1 }}
                            </td>
                            <td>
                                <div style="font-weight: 700; font-size: 12.5px;">
                                    {{ $pk->nama }}
                                </div>
                            </td>
                            <td>
                                @if ($pk->departemen)
                                    <span class="badge-himapro badge-yellow">
                                        {{ $pk->departemen->nama }}
                                    </span>
                                @else
                                    <span style="color: var(--muted);">—</span>
                                @endif
                            </td>
                            <td style="font-size: 12px;">
                                {{ $pk->periode }}
                            </td>
                            <td style="font-size: 11.5px; color: var(--muted);">
                                @if ($pk->tanggal_mulai)
                                    {{ $pk->tanggal_mulai->format('d M Y') }}
                                    @if ($pk->tanggal_selesai)
                                        <br>s/d {{ $pk->tanggal_selesai->format('d M Y') }}
                                    @endif
                                @else
                                    —
                                @endif
                            </td>
                            <td class="text-end" style="font-weight: 700; font-size: 12.5px; color: var(--primary);">
                                Rp {{ number_format($pk->anggaran, 0, ',', '.') }}
                            </td>
                            <td>
                                @switch($pk->status)
                                    @case('planned')
                                        <span class="badge-himapro badge-yellow">Direncanakan</span>
                                        @break
                                    @case('ongoing')
                                        <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                                            Berjalan
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="badge-himapro badge-active">Selesai</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge-himapro badge-inactive">Dibatalkan</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-kanban"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Tidak ada program kerja</h6>
                                <p class="mb-0">Belum ada data pada filter ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection


@push('styles')
<style>
@media print {
    .no-print,
    .admin-sidebar,
    .admin-navbar,
    .sidebar-toggle-btn,
    .page-header-breadcrumb,
    .admin-user {
        display: none !important;
    }

    .admin-main { margin-left: 0 !important; }
    .admin-content { padding: 0 !important; }
    body { background: white !important; color: black !important; }

    .admin-card,
    .stat-card {
        background: white !important;
        border: 1px solid #ccc !important;
        color: black !important;
        box-shadow: none !important;
        break-inside: avoid;
    }

    .stat-value,
    .stat-label {
        color: black !important;
    }

    .table-dark {
        --bs-table-color: black;
        --bs-table-bg: white;
    }
}
</style>
@endpush