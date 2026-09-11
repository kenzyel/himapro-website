@extends('layouts.admin')

@section('title', $anggaran->nama)

@section('content')

<a href="{{ route('admin.anggaran.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Anggaran
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $anggaran->nama }}</h1>
        <p>Detail anggaran periode {{ $anggaran->periode }}.</p>
    </div>

    @if (auth()->user()->hasPermission('anggaran.update'))
        <a href="{{ route('admin.anggaran.edit', $anggaran) }}" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-pencil"></i>
            Edit
        </a>
    @endif
</div>


<div class="row g-4">

    <div class="col-lg-8">
        <div class="admin-card" data-aos="fade-up">

            <div class="card-header d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <h2 class="admin-card-title">Informasi Anggaran</h2>

                @switch($anggaran->status)
                    @case('draft')
                        <span class="badge-himapro badge-yellow">Draft</span>
                        @break
                    @case('approved')
                        <span class="badge-himapro badge-active">Disetujui</span>
                        @break
                    @case('realized')
                        <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                            Realisasi
                        </span>
                        @break
                    @case('cancelled')
                        <span class="badge-himapro badge-inactive">Dibatalkan</span>
                        @break
                @endswitch
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Nama Anggaran</div>
                        <div class="info-block-value">{{ $anggaran->nama }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Periode</div>
                        <div class="info-block-value">{{ $anggaran->periode }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Departemen</div>
                        <div class="info-block-value">
                            {{ $anggaran->departemen?->nama ?? 'Tidak terkait departemen' }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Program Kerja</div>
                        <div class="info-block-value">
                            {{ $anggaran->programKerja?->nama ?? 'Tidak terkait program kerja' }}
                        </div>
                    </div>

                    <div class="col-12 info-block">
                        <div class="info-block-label">Jumlah Anggaran</div>
                        <div style="
                            font-size: 26px;
                            font-weight: 900;
                            color: var(--primary);
                            letter-spacing: -0.02em;
                            margin-top: 6px;
                        ">
                            Rp {{ number_format($anggaran->jumlah, 0, ',', '.') }}
                        </div>
                    </div>

                    @if ($anggaran->keterangan)
                        <div class="col-12 info-block" style="margin-bottom: 0;">
                            <div class="info-block-label">Keterangan</div>
                            <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                                {!! nl2br(e($anggaran->keterangan)) !!}
                            </div>
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>


    <div class="col-lg-4">
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header">
                <h2 class="admin-card-title">Metadata</h2>
            </div>
            <div class="card-body">

                <div class="info-block">
                    <div class="info-block-label">Status</div>
                    <div>
                        @switch($anggaran->status)
                            @case('draft')
                                <span class="badge-himapro badge-yellow">Draft</span>
                                @break
                            @case('approved')
                                <span class="badge-himapro badge-active">Disetujui</span>
                                @break
                            @case('realized')
                                <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                                    Realisasi
                                </span>
                                @break
                            @case('cancelled')
                                <span class="badge-himapro badge-inactive">Dibatalkan</span>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Dibuat</div>
                    <div class="info-block-value">
                        {{ $anggaran->created_at?->format('d F Y, H:i') }}
                    </div>
                </div>

                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Terakhir Update</div>
                    <div class="info-block-value" style="font-size: 12px;">
                        {{ $anggaran->updated_at?->format('d M Y, H:i') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.anggaran.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('anggaran.delete'))
        <form action="{{ route('admin.anggaran.destroy', $anggaran) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus anggaran ini?')">
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