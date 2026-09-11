@extends('layouts.admin')

@section('title', $programKerja->nama)

@section('content')

<a href="{{ route('admin.program-kerja.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Program Kerja
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $programKerja->nama }}</h1>
        <p>Periode {{ $programKerja->periode }} — {{ $programKerja->departemen->nama ?? 'Tanpa Departemen' }}</p>
    </div>

    @if (auth()->user()->hasPermission('program-kerja.update'))
        <a href="{{ route('admin.program-kerja.edit', $programKerja) }}" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-pencil"></i>
            Edit
        </a>
    @endif
</div>


<div class="row g-4">

    <div class="col-lg-8">
        <div class="admin-card" data-aos="fade-up">

            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center gap-3 flex-wrap">
                    <h2 class="admin-card-title">Informasi Program Kerja</h2>

                    @switch($programKerja->status)
                        @case('planned')
                            <span class="badge-himapro badge-yellow">Direncanakan</span>
                            @break
                        @case('ongoing')
                            <span class="badge-himapro badge-active">Berjalan</span>
                            @break
                        @case('completed')
                            <span class="badge-himapro badge-active">Selesai</span>
                            @break
                        @case('cancelled')
                            <span class="badge-himapro badge-inactive">Dibatalkan</span>
                            @break
                    @endswitch
                </div>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Departemen</div>
                        <div class="info-block-value">{{ $programKerja->departemen->nama ?? '—' }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Kode Departemen</div>
                        <div class="info-block-value">{{ $programKerja->departemen->kode ?? '—' }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Periode</div>
                        <div class="info-block-value">{{ $programKerja->periode }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Anggaran</div>
                        <div class="info-block-value" style="color: var(--primary); font-weight: 800; font-size: 16px;">
                            Rp {{ number_format((float) $programKerja->anggaran, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Tanggal Mulai</div>
                        <div class="info-block-value">
                            {{ $programKerja->tanggal_mulai?->format('d F Y') ?? 'Belum ditentukan' }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Tanggal Selesai</div>
                        <div class="info-block-value">
                            {{ $programKerja->tanggal_selesai?->format('d F Y') ?? 'Belum ditentukan' }}
                        </div>
                    </div>

                    <div class="col-12 info-block">
                        <div class="info-block-label">Deskripsi</div>
                        <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                            {!! nl2br(e($programKerja->deskripsi ?: 'Belum ada deskripsi.')) !!}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Tujuan</div>
                        <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                            {!! nl2br(e($programKerja->tujuan ?: 'Belum ada tujuan.')) !!}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Target</div>
                        <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                            {!! nl2br(e($programKerja->target ?: 'Belum ada target.')) !!}
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>


    <div class="col-lg-4">
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">

            <div class="card-header">
                <h2 class="admin-card-title">Statistik</h2>
                <p class="card-subtitle">Ringkasan data program kerja</p>
            </div>

            <div class="card-body">

                <div class="stat-mini">
                    <div class="stat-mini-label">
                        <i class="bi bi-calendar-event-fill"></i>
                        Agenda
                    </div>
                    <div class="stat-mini-value">{{ $programKerja->agendas->count() }}</div>
                </div>

                <div class="stat-mini">
                    <div class="stat-mini-label">
                        <i class="bi bi-cash-stack"></i>
                        Anggaran
                    </div>
                    <div class="stat-mini-value">{{ $programKerja->anggarans->count() }}</div>
                </div>

                <div class="stat-mini" style="margin-bottom: 0;">
                    <div class="stat-mini-label">
                        <i class="bi bi-wallet2"></i>
                        Transaksi Keuangan
                    </div>
                    <div class="stat-mini-value">{{ $programKerja->keuangans->count() }}</div>
                </div>

            </div>

        </div>
    </div>

</div>


<div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="150">

    <div class="card-header">
        <h2 class="admin-card-title">Agenda Program Kerja</h2>
        <p class="card-subtitle">Daftar agenda terkait program kerja ini</p>
    </div>

    <div class="card-body p-0">

        @if ($programKerja->agendas->count() > 0)
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="px-4">Judul</th>
                            <th>Lokasi</th>
                            <th>Mulai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($programKerja->agendas as $agenda)
                            <tr>
                                <td class="px-4" style="font-weight: 700; font-size: 13px;">
                                    {{ $agenda->judul }}
                                </td>
                                <td style="font-size: 12.5px; color: var(--muted);">
                                    {{ $agenda->lokasi ?: '—' }}
                                </td>
                                <td style="font-size: 12.5px;">
                                    {{ $agenda->tanggal_mulai?->format('d M Y H:i') ?? '—' }}
                                </td>
                                <td>
                                    <span class="badge-himapro badge-yellow">
                                        {{ ucfirst($agenda->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-calendar-x"></i>
                </div>
                <p class="mb-0">Belum ada agenda untuk program kerja ini.</p>
            </div>
        @endif

    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.program-kerja.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('program-kerja.update'))
        <a href="{{ route('admin.program-kerja.edit', $programKerja) }}" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-pencil"></i>
            Edit Program Kerja
        </a>
    @endif
</div>

@endsection