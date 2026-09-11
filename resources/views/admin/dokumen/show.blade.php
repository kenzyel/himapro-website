@extends('layouts.admin')

@section('title', $dokumen->nama)

@section('content')

<a href="{{ route('admin.dokumen.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Dokumen
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $dokumen->nama }}</h1>
        <p>Detail informasi dokumen.</p>
    </div>

    <div class="d-flex gap-2">
        @if ($dokumen->file_path)
            <a href="{{ asset('storage/' . $dokumen->file_path) }}"
               target="_blank"
               class="btn-himapro btn-himapro-secondary">
                <i class="bi bi-download"></i>
                Unduh
            </a>
        @endif

        @if (auth()->user()->hasPermission('dokumen.update'))
            <a href="{{ route('admin.dokumen.edit', $dokumen) }}" class="btn-himapro btn-himapro-primary">
                <i class="bi bi-pencil"></i>
                Edit
            </a>
        @endif
    </div>
</div>


<div class="row g-4">

    <div class="col-lg-4">
        <div class="admin-card" data-aos="fade-up">
            <div class="card-body text-center" style="padding: 32px 24px;">

                <div style="
                    width: 100px;
                    height: 100px;
                    margin: 0 auto 20px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: var(--radius-lg);
                    background: linear-gradient(135deg, var(--primary), var(--secondary));
                    color: #111;
                    font-size: 46px;
                    box-shadow: 0 8px 24px rgba(255,210,26,.3);
                ">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>

                <div style="font-weight: 700; font-size: 13px; word-break: break-all;">
                    {{ $dokumen->file_name }}
                </div>

                <div style="font-size: 11.5px; color: var(--muted); margin-top: 6px;">
                    {{ number_format($dokumen->file_size / 1024, 0) }} KB
                </div>

                <div style="margin-top: 16px;">
                    @if ($dokumen->is_public)
                        <span class="badge-himapro badge-active">
                            <i class="bi bi-globe"></i> Publik
                        </span>
                    @else
                        <span class="badge-himapro badge-inactive">
                            <i class="bi bi-lock"></i> Internal
                        </span>
                    @endif
                </div>

            </div>
        </div>
    </div>


    <div class="col-lg-8">
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">

            <div class="card-header">
                <h2 class="admin-card-title">Informasi Dokumen</h2>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Nama Dokumen</div>
                        <div class="info-block-value">{{ $dokumen->nama }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Kategori</div>
                        <div class="info-block-value">
                            <span class="badge-himapro badge-yellow">
                                {{ ucfirst($dokumen->kategori) }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Periode</div>
                        <div class="info-block-value">
                            {{ $dokumen->periode ?: '—' }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">MIME Type</div>
                        <div class="info-block-value" style="font-weight: 500; color: var(--muted);">
                            <code>{{ $dokumen->mime_type ?: '—' }}</code>
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Diunggah Oleh</div>
                        <div class="info-block-value">
                            {{ $dokumen->user?->name ?? 'System' }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Tanggal Upload</div>
                        <div class="info-block-value">
                            {{ $dokumen->created_at?->format('d F Y, H:i') }}
                        </div>
                    </div>

                    <div class="col-12 info-block" style="margin-bottom: 0;">
                        <div class="info-block-label">Deskripsi</div>
                        <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                            {!! nl2br(e($dokumen->deskripsi ?: 'Belum ada deskripsi.')) !!}
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.dokumen.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('dokumen.delete'))
        <form action="{{ route('admin.dokumen.destroy', $dokumen) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus dokumen ini? File juga akan dihapus dari penyimpanan.')">
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