@extends('layouts.admin')

@section('title', 'Laporan')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Laporan</h1>
    <p>Ringkasan dan rekap data HIMAPRO TI SAKTI.</p>
</div>


{{-- RINGKASAN CEPAT --}}
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Pengurus</span>
                <span class="stat-icon"><i class="bi bi-people-fill"></i></span>
            </div>
            <div class="stat-value">{{ $ringkasan['total_pengurus'] }}</div>
            <div class="stat-description">Pengurus aktif</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Departemen</span>
                <span class="stat-icon"><i class="bi bi-diagram-3-fill"></i></span>
            </div>
            <div class="stat-value">{{ $ringkasan['total_departemen'] }}</div>
            <div class="stat-description">Departemen aktif</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Program Kerja</span>
                <span class="stat-icon"><i class="bi bi-kanban-fill"></i></span>
            </div>
            <div class="stat-value">{{ $ringkasan['total_program_kerja'] }}</div>
            <div class="stat-description">Terdaftar</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Agenda</span>
                <span class="stat-icon"><i class="bi bi-calendar-event-fill"></i></span>
            </div>
            <div class="stat-value">{{ $ringkasan['total_agenda'] }}</div>
            <div class="stat-description">Terdaftar</div>
        </div>
    </div>
</div>


{{-- RINGKASAN KEUANGAN --}}
<div class="row g-3 mb-4" data-aos="fade-up" data-aos-delay="100">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Pemasukan</span>
                <span class="stat-icon" style="background: rgba(34,197,94,.1); color: #86efac; border-color: rgba(34,197,94,.2);">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="font-size: 18px; color: #86efac;">
                Rp {{ number_format($ringkasan['total_pemasukan'], 0, ',', '.') }}
            </div>
            <div class="stat-description">Transaksi disetujui</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Pengeluaran</span>
                <span class="stat-icon" style="background: rgba(239,68,68,.1); color: #fca5a5; border-color: rgba(239,68,68,.2);">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="font-size: 18px; color: #fca5a5;">
                Rp {{ number_format($ringkasan['total_pengeluaran'], 0, ',', '.') }}
            </div>
            <div class="stat-description">Transaksi disetujui</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Saldo</span>
                <span class="stat-icon"><i class="bi bi-wallet2"></i></span>
            </div>
            <div class="stat-value" style="font-size: 18px; color: var(--primary);">
                Rp {{ number_format($ringkasan['saldo'], 0, ',', '.') }}
            </div>
            <div class="stat-description">Pemasukan - pengeluaran</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Anggaran</span>
                <span class="stat-icon"><i class="bi bi-cash-stack"></i></span>
            </div>
            <div class="stat-value" style="font-size: 18px;">
                Rp {{ number_format($ringkasan['total_anggaran'], 0, ',', '.') }}
            </div>
            <div class="stat-description">Anggaran direncanakan</div>
        </div>
    </div>
</div>


{{-- PILIH JENIS LAPORAN --}}
<div class="admin-card" data-aos="fade-up" data-aos-delay="200">

    <div class="card-header">
        <h2 class="admin-card-title">Jenis Laporan</h2>
        <p class="card-subtitle">Pilih laporan yang ingin dilihat atau dicetak</p>
    </div>

    <div class="card-body">
        <div class="row g-3">

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('admin.laporan.keuangan') }}" class="quick-action" style="height: 100%;">
                    <div class="quick-action-icon" style="background: rgba(34,197,94,.1); color: #86efac; border-color: rgba(34,197,94,.2);">
                        <i class="bi bi-wallet2"></i>
                    </div>
                    <strong>Laporan Keuangan</strong>
                    <span>Rekap pemasukan, pengeluaran, dan saldo berdasarkan periode.</span>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('admin.laporan.program-kerja') }}" class="quick-action" style="height: 100%;">
                    <div class="quick-action-icon">
                        <i class="bi bi-kanban-fill"></i>
                    </div>
                    <strong>Laporan Program Kerja</strong>
                    <span>Rekap program kerja berdasarkan periode, departemen, dan status.</span>
                </a>
            </div>

            <div class="col-lg-4 col-md-6">
                <a href="{{ route('admin.laporan.agenda') }}" class="quick-action" style="height: 100%;">
                    <div class="quick-action-icon">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <strong>Laporan Agenda</strong>
                    <span>Rekap agenda dan kegiatan dalam rentang tanggal tertentu.</span>
                </a>
            </div>

        </div>
    </div>

</div>

@endsection