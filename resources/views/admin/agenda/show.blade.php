@extends('layouts.admin')

@section('title', $pengumuman->judul)

@section('content')

<a href="{{ route('admin.pengumuman.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Pengumuman
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $pengumuman->judul }}</h1>
        <p>Detail pengumuman HIMAPRO TI SAKTI.</p>
    </div>

    @if (auth()->user()->hasPermission('pengumuman.update'))
        <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-pencil"></i>
            Edit
        </a>
    @endif
</div>


<div class="row g-4">

    <div class="col-lg-8">
        <div class="admin-card" data-aos="fade-up">

            <div class="card-header">
                <h2 class="admin-card-title">{{ $pengumuman->judul }}</h2>
            </div>

            <div class="card-body">

                @if ($pengumuman->ringkasan)
                    <div style="
                        padding: 16px 18px;
                        border-radius: var(--radius);
                        background: rgba(255, 210, 26, 0.05);
                        border: 1px solid rgba(255, 210, 26, 0.15);
                        margin-bottom: 22px;
                    ">
                        <div class="info-block-label" style="margin-bottom: 8px;">Ringkasan</div>
                        <div style="font-size: 13.5px; line-height: 1.7; color: var(--text);">
                            {{ $pengumuman->ringkasan }}
                        </div>
                    </div>
                @endif

                <div style="
                    white-space: pre-line;
                    line-height: 1.9;
                    font-size: 14px;
                    color: var(--text);
                ">
                    {{ $pengumuman->isi }}
                </div>

            </div>

        </div>
    </div>


    <div class="col-lg-4">
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">

            <div class="card-header">
                <h2 class="admin-card-title">Informasi</h2>
            </div>

            <div class="card-body">

                <div class="info-block">
                    <div class="info-block-label">Status</div>
                    <div>
                        @switch($pengumuman->status)
                            @case('draft')
                                <span class="badge-himapro badge-yellow">Draft</span>
                                @break
                            @case('published')
                                <span class="badge-himapro badge-active">Published</span>
                                @break
                            @case('archived')
                                <span class="badge-himapro badge-inactive">Diarsipkan</span>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Publikasi</div>
                    <div>
                        @if ($pengumuman->is_published)
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

                <div class="info-block">
                    <div class="info-block-label">Tanggal Publikasi</div>
                    <div class="info-block-value">
                        {{ $pengumuman->published_at?->format('d F Y, H:i') ?? 'Belum dipublikasikan' }}
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Dibuat</div>
                    <div class="info-block-value">
                        {{ $pengumuman->created_at?->format('d F Y, H:i') }}
                    </div>
                </div>

                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Slug</div>
                    <div class="info-block-value" style="color: var(--muted); font-weight: 500;">
                        <code>{{ $pengumuman->slug }}</code>
                    </div>
                </div>

            </div>

        </div>
    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.pengumuman.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('pengumuman.delete'))
        <form action="{{ route('admin.pengumuman.destroy', $pengumuman) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
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