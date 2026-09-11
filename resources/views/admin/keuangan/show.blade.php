@extends('layouts.admin')

@section('title', $keuangan->deskripsi)

@section('content')

<a href="{{ route('admin.keuangan.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Keuangan
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $keuangan->deskripsi }}</h1>
        <p>Detail transaksi keuangan.</p>
    </div>

    @if (auth()->user()->hasPermission('keuangan.update'))
        <a href="{{ route('admin.keuangan.edit', $keuangan) }}" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-pencil"></i>
            Edit
        </a>
    @endif
</div>


<div class="row g-4">

    <div class="col-lg-8">

        <div class="admin-card" data-aos="fade-up">

            <div class="card-header d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <h2 class="admin-card-title">Informasi Transaksi</h2>

                @if ($keuangan->jenis === 'pemasukan')
                    <span class="badge-himapro" style="background: rgba(34,197,94,.12); color: #86efac; border-color: rgba(34,197,94,.25);">
                        <i class="bi bi-arrow-down-circle-fill"></i> Pemasukan
                    </span>
                @else
                    <span class="badge-himapro" style="background: rgba(239,68,68,.12); color: #fca5a5; border-color: rgba(239,68,68,.25);">
                        <i class="bi bi-arrow-up-circle-fill"></i> Pengeluaran
                    </span>
                @endif
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Tanggal</div>
                        <div class="info-block-value">
                            {{ $keuangan->tanggal?->format('d F Y') }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Kategori</div>
                        <div class="info-block-value">
                            <span class="badge-himapro badge-yellow">
                                {{ ucfirst(str_replace('_', ' ', $keuangan->kategori)) }}
                            </span>
                        </div>
                    </div>

                    <div class="col-12 info-block">
                        <div class="info-block-label">Deskripsi</div>
                        <div class="info-block-value">
                            {{ $keuangan->deskripsi }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Departemen</div>
                        <div class="info-block-value">
                            {{ $keuangan->departemen?->nama ?? '—' }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Program Kerja</div>
                        <div class="info-block-value">
                            {{ $keuangan->programKerja?->nama ?? '—' }}
                        </div>
                    </div>

                    <div class="col-12 info-block">
                        <div class="info-block-label">Jumlah</div>
                        <div style="
                            font-size: 28px;
                            font-weight: 900;
                            color: {{ $keuangan->jenis === 'pemasukan' ? '#86efac' : '#fca5a5' }};
                            letter-spacing: -0.02em;
                            margin-top: 6px;
                        ">
                            {{ $keuangan->jenis === 'pemasukan' ? '+' : '-' }}
                            Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}
                        </div>
                    </div>

                    @if ($keuangan->keterangan)
                        <div class="col-12 info-block" style="margin-bottom: 0;">
                            <div class="info-block-label">Keterangan</div>
                            <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                                {!! nl2br(e($keuangan->keterangan)) !!}
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>


        @if ($keuangan->bukti_path)
            <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header">
                    <h2 class="admin-card-title">Bukti Transaksi</h2>
                    <p class="card-subtitle">File bukti yang diunggah</p>
                </div>
                <div class="card-body text-center">

                    <img src="{{ asset('storage/' . $keuangan->bukti_path) }}"
                         alt="Bukti transaksi"
                         style="max-width: 100%; max-height: 500px; border-radius: var(--radius); border: 1px solid var(--border);">

                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $keuangan->bukti_path) }}"
                           target="_blank"
                           class="btn-himapro btn-himapro-secondary">
                            <i class="bi bi-arrows-fullscreen"></i>
                            Lihat Full Size
                        </a>
                    </div>

                </div>
            </div>
        @endif

    </div>


    <div class="col-lg-4">
        <div class="admin-card" data-aos="fade-up" data-aos-delay="150">
            <div class="card-header">
                <h2 class="admin-card-title">Metadata</h2>
            </div>
            <div class="card-body">

                <div class="info-block">
                    <div class="info-block-label">Status</div>
                    <div>
                        @switch($keuangan->status)
                            @case('pending')
                                <span class="badge-himapro" style="background: rgba(251,191,36,.12); color: #fbbf24; border-color: rgba(251,191,36,.25);">
                                    Pending
                                </span>
                                @break
                            @case('approved')
                                <span class="badge-himapro badge-active">Disetujui</span>
                                @break
                            @case('rejected')
                                <span class="badge-himapro badge-inactive">Ditolak</span>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Dicatat Oleh</div>
                    <div class="info-block-value">
                        {{ $keuangan->user?->name ?? 'System' }}
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Dibuat</div>
                    <div class="info-block-value">
                        {{ $keuangan->created_at?->format('d F Y, H:i') }}
                    </div>
                </div>

                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Terakhir Update</div>
                    <div class="info-block-value" style="font-size: 12px;">
                        {{ $keuangan->updated_at?->format('d M Y, H:i') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.keuangan.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('keuangan.delete'))
        <form action="{{ route('admin.keuangan.destroy', $keuangan) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-himapro btn-himapro-danger">
                <i class="bi bi-trash"></i>
                Hapus
            </button>
        </form>
    @endif
</div>

@endsection