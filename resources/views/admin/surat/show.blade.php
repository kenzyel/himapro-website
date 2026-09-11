@extends('layouts.admin')

@section('title', $surat->nomor_surat)

@section('content')

<a href="{{ route('admin.surat.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Surat
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $surat->nomor_surat }}</h1>
        <p>{{ $surat->perihal }}</p>
    </div>

    <div class="d-flex gap-2">
        @if ($surat->file_path)
            <a href="{{ asset('storage/' . $surat->file_path) }}"
               target="_blank"
               class="btn-himapro btn-himapro-secondary">
                <i class="bi bi-download"></i>
                Unduh
            </a>
        @endif

        @if (auth()->user()->hasPermission('surat.update'))
            <a href="{{ route('admin.surat.edit', $surat) }}" class="btn-himapro btn-himapro-primary">
                <i class="bi bi-pencil"></i>
                Edit
            </a>
        @endif
    </div>
</div>


<div class="row g-4">

    <div class="col-lg-8">
        <div class="admin-card" data-aos="fade-up">

            <div class="card-header d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <h2 class="admin-card-title">Informasi Surat</h2>

                @if ($surat->jenis === 'masuk')
                    <span class="badge-himapro" style="background: rgba(34,197,94,.12); color: #86efac; border-color: rgba(34,197,94,.25);">
                        <i class="bi bi-inbox-fill"></i> Surat Masuk
                    </span>
                @else
                    <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                        <i class="bi bi-send-fill"></i> Surat Keluar
                    </span>
                @endif
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Nomor Surat</div>
                        <div class="info-block-value">{{ $surat->nomor_surat }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Status</div>
                        <div>
                            @switch($surat->status)
                                @case('draft')
                                    <span class="badge-himapro badge-yellow">Draft</span>
                                    @break
                                @case('sent')
                                    <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                                        Terkirim
                                    </span>
                                    @break
                                @case('received')
                                    <span class="badge-himapro badge-active">Diterima</span>
                                    @break
                                @case('archived')
                                    <span class="badge-himapro" style="background: rgba(255,255,255,.05); color: var(--muted); border-color: var(--border);">
                                        Diarsipkan
                                    </span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    <div class="col-12 info-block">
                        <div class="info-block-label">Perihal</div>
                        <div class="info-block-value">{{ $surat->perihal }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Pengirim</div>
                        <div class="info-block-value">
                            {{ $surat->pengirim ?: '—' }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Penerima</div>
                        <div class="info-block-value">
                            {{ $surat->penerima ?: '—' }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Tanggal Surat</div>
                        <div class="info-block-value">
                            {{ $surat->tanggal_surat?->format('d F Y') }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Tanggal Terima</div>
                        <div class="info-block-value">
                            {{ $surat->tanggal_terima?->format('d F Y') ?? 'Belum diterima' }}
                        </div>
                    </div>

                    @if ($surat->keterangan)
                        <div class="col-12 info-block" style="margin-bottom: 0;">
                            <div class="info-block-label">Keterangan</div>
                            <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                                {!! nl2br(e($surat->keterangan)) !!}
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
                <h2 class="admin-card-title">Informasi Tambahan</h2>
            </div>
            <div class="card-body">

                <div class="info-block">
                    <div class="info-block-label">Dibuat Oleh</div>
                    <div class="info-block-value">
                        {{ $surat->user?->name ?? 'System' }}
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Tanggal Input</div>
                    <div class="info-block-value">
                        {{ $surat->created_at?->format('d F Y, H:i') }}
                    </div>
                </div>

                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Terakhir Update</div>
                    <div class="info-block-value" style="font-size: 12px;">
                        {{ $surat->updated_at?->format('d M Y, H:i') }}
                    </div>
                </div>

            </div>
        </div>


        @if ($surat->file_path)
            <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="150">
                <div class="card-header">
                    <h2 class="admin-card-title">File Surat</h2>
                </div>
                <div class="card-body text-center">

                    <div style="
                        width: 80px;
                        height: 80px;
                        margin: 0 auto 14px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        border-radius: var(--radius-lg);
                        background: linear-gradient(135deg, var(--primary), var(--secondary));
                        color: #111;
                        font-size: 36px;
                    ">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>

                    <div style="font-weight: 700; font-size: 12.5px; word-break: break-all; margin-bottom: 12px;">
                        {{ basename($surat->file_path) }}
                    </div>

                    <a href="{{ asset('storage/' . $surat->file_path) }}"
                       target="_blank"
                       class="btn-himapro btn-himapro-primary"
                       style="width: 100%; justify-content: center;">
                        <i class="bi bi-download"></i>
                        Unduh File
                    </a>

                </div>
            </div>
        @endif

    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.surat.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('surat.delete'))
        <form action="{{ route('admin.surat.destroy', $surat) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
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