@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')

<a href="{{ route('admin.laporan.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Laporan
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>Laporan Keuangan</h1>
        <p>Rekap transaksi keuangan disetujui.</p>
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

            <div class="col-lg-4 col-md-5">
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="from" class="form-control" value="{{ $from }}">
            </div>

            <div class="col-lg-4 col-md-5">
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="to" class="form-control" value="{{ $to }}">
            </div>

            <div class="col-lg-4 col-md-2 d-flex gap-2 align-items-end">
                <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                    <i class="bi bi-funnel-fill"></i>
                    Terapkan
                </button>

                @if ($from || $to)
                    <a href="{{ route('admin.laporan.keuangan') }}" class="btn-icon" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                @endif
            </div>

        </div>
    </form>
</div>


{{-- SUMMARY --}}
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-lg-4 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Pemasukan</span>
                <span class="stat-icon" style="background: rgba(34,197,94,.1); color: #86efac; border-color: rgba(34,197,94,.2);">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="font-size: 22px; color: #86efac;">
                Rp {{ number_format($summary['total_pemasukan'], 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Pengeluaran</span>
                <span class="stat-icon" style="background: rgba(239,68,68,.1); color: #fca5a5; border-color: rgba(239,68,68,.2);">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="font-size: 22px; color: #fca5a5;">
                Rp {{ number_format($summary['total_pengeluaran'], 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-12">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Saldo</span>
                <span class="stat-icon"><i class="bi bi-wallet2"></i></span>
            </div>
            <div class="stat-value" style="font-size: 22px; color: var(--primary);">
                Rp {{ number_format($summary['saldo'], 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>


{{-- REKAP PER KATEGORI --}}
@if ($perKategori->count() > 0)
    <div class="admin-card mb-4" data-aos="fade-up">
        <div class="card-header">
            <h2 class="admin-card-title">Rekap per Kategori</h2>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="px-4">Kategori</th>
                            <th class="text-end">Pemasukan</th>
                            <th class="text-end">Pengeluaran</th>
                            <th class="text-end px-4">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($perKategori as $item)
                            <tr>
                                <td class="px-4" style="font-weight: 700; font-size: 13px;">
                                    {{ ucfirst(str_replace('_', ' ', $item['kategori'])) }}
                                </td>
                                <td class="text-end" style="color: #86efac; font-weight: 700; font-size: 12.5px;">
                                    Rp {{ number_format($item['pemasukan'], 0, ',', '.') }}
                                </td>
                                <td class="text-end" style="color: #fca5a5; font-weight: 700; font-size: 12.5px;">
                                    Rp {{ number_format($item['pengeluaran'], 0, ',', '.') }}
                                </td>
                                <td class="text-end px-4" style="font-weight: 800; font-size: 12.5px;">
                                    Rp {{ number_format($item['total'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif


{{-- DETAIL TRANSAKSI --}}
<div class="admin-card" data-aos="fade-up" data-aos-delay="100">
    <div class="card-header">
        <h2 class="admin-card-title">Detail Transaksi</h2>
        <p class="card-subtitle">{{ $summary['jumlah_transaksi'] }} transaksi ditampilkan</p>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="px-4" width="60">#</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th class="text-end px-4">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $index => $trx)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $index + 1 }}
                            </td>
                            <td style="font-size: 12.5px;">
                                {{ $trx->tanggal?->format('d M Y') }}
                            </td>
                            <td>
                                <div style="font-weight: 700; font-size: 12.5px;">
                                    {{ $trx->deskripsi }}
                                </div>
                                @if ($trx->departemen || $trx->programKerja)
                                    <div style="font-size: 10.5px; color: var(--muted); margin-top: 3px;">
                                        {{ $trx->departemen?->nama }}
                                        @if ($trx->departemen && $trx->programKerja) · @endif
                                        {{ $trx->programKerja?->nama }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge-himapro badge-yellow">
                                    {{ ucfirst(str_replace('_', ' ', $trx->kategori)) }}
                                </span>
                            </td>
                            <td>
                                @if ($trx->jenis === 'pemasukan')
                                    <span style="color: #86efac; font-size: 11.5px; font-weight: 700;">
                                        <i class="bi bi-arrow-down"></i> Masuk
                                    </span>
                                @else
                                    <span style="color: #fca5a5; font-size: 11.5px; font-weight: 700;">
                                        <i class="bi bi-arrow-up"></i> Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="text-end px-4">
                                <div style="font-weight: 800; font-size: 13px; color: {{ $trx->jenis === 'pemasukan' ? '#86efac' : '#fca5a5' }};">
                                    {{ $trx->jenis === 'pemasukan' ? '+' : '-' }}
                                    Rp {{ number_format($trx->jumlah, 0, ',', '.') }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Tidak ada transaksi</h6>
                                <p class="mb-0">Belum ada transaksi pada periode ini.</p>
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

    .admin-main {
        margin-left: 0 !important;
    }

    .admin-content {
        padding: 0 !important;
    }

    body {
        background: white !important;
        color: black !important;
    }

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

    table {
        color: black !important;
    }

    .table-dark {
        --bs-table-color: black;
        --bs-table-bg: white;
    }
}
</style>
@endpush