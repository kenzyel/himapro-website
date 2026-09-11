@extends('layouts.admin')

@section('title', $notulensi->judul)

@section('content')

<a href="{{ route('admin.notulensi.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Notulensi
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $notulensi->judul }}</h1>
        <p>Notulensi rapat tanggal {{ $notulensi->tanggal?->format('d F Y') }}.</p>
    </div>

    <div class="d-flex gap-2">
        @if ($notulensi->file_path)
            <a href="{{ asset('storage/' . $notulensi->file_path) }}"
               target="_blank"
               class="btn-himapro btn-himapro-secondary">
                <i class="bi bi-download"></i>
                Unduh File
            </a>
        @endif

        @if (auth()->user()->hasPermission('notulensi.update'))
            <a href="{{ route('admin.notulensi.edit', $notulensi) }}" class="btn-himapro btn-himapro-primary">
                <i class="bi bi-pencil"></i>
                Edit
            </a>
        @endif
    </div>
</div>


<div class="row g-4">

    <div class="col-lg-8">

        @if ($notulensi->agenda)
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="card-header">
                    <h2 class="admin-card-title">Agenda Rapat</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 13.5px; line-height: 1.8; white-space: pre-line;">
                        {{ $notulensi->agenda }}
                    </div>
                </div>
            </div>
        @endif

        <div class="admin-card" data-aos="fade-up" data-aos-delay="50">
            <div class="card-header">
                <h2 class="admin-card-title">Isi Notulensi</h2>
            </div>
            <div class="card-body">
                <div style="
                    font-size: 14px;
                    line-height: 1.9;
                    white-space: pre-line;
                    color: var(--text);
                ">{{ $notulensi->isi }}</div>
            </div>
        </div>

    </div>


    <div class="col-lg-4">

        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header">
                <h2 class="admin-card-title">Informasi Rapat</h2>
            </div>
            <div class="card-body">

                <div class="info-block">
                    <div class="info-block-label">Status</div>
                    <div>
                        @switch($notulensi->status)
                            @case('draft')
                                <span class="badge-himapro badge-yellow">Draft</span>
                                @break
                            @case('final')
                                <span class="badge-himapro badge-active">Final</span>
                                @break
                            @case('archived')
                                <span class="badge-himapro" style="background: rgba(255,255,255,.05); color: var(--muted); border-color: var(--border);">
                                    Diarsipkan
                                </span>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Tanggal & Waktu</div>
                    <div class="info-block-value">
                        {{ $notulensi->tanggal?->format('d F Y, H:i') }}
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Tempat</div>
                    <div class="info-block-value">
                        {{ $notulensi->tempat ?: 'Belum ditentukan' }}
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Dibuat Oleh</div>
                    <div class="info-block-value">
                        {{ $notulensi->user?->name ?? 'System' }}
                    </div>
                </div>

                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Terakhir Update</div>
                    <div class="info-block-value" style="font-size: 12px;">
                        {{ $notulensi->updated_at?->format('d M Y, H:i') }}
                    </div>
                </div>

            </div>
        </div>


        @if ($notulensi->peserta)
            <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="150">
                <div class="card-header">
                    <h2 class="admin-card-title">Peserta Rapat</h2>
                </div>
                <div class="card-body">
                    <div style="font-size: 13px; line-height: 1.9; white-space: pre-line; color: var(--muted);">
                        {{ $notulensi->peserta }}
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.notulensi.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('notulensi.delete'))
        <form action="{{ route('admin.notulensi.destroy', $notulensi) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus notulensi ini?')">
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