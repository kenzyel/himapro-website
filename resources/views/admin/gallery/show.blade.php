@extends('layouts.admin')

@section('title', $gallery->nama)

@section('content')

<a href="{{ route('admin.gallery.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Gallery
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $gallery->nama }}</h1>
        <p>{{ $gallery->deskripsi ?: 'Kelola foto yang terdapat di dalam galeri ini.' }}</p>
    </div>

    <div class="d-flex flex-wrap gap-2">
        @if (auth()->user()->hasPermission('gallery.update'))
            <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn-himapro btn-himapro-secondary">
                <i class="bi bi-pencil"></i>
                Edit Gallery
            </a>
        @endif

        @if (auth()->user()->hasPermission('gallery.create'))
            <a href="{{ route('admin.gallery.items.create', $gallery) }}" class="btn-himapro btn-himapro-primary">
                <i class="bi bi-plus-lg"></i>
                Tambah Foto
            </a>
        @endif
    </div>
</div>


@if (session('success'))
    <div class="alert alert-success alert-dismissible" data-aos="fade-down">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible" data-aos="fade-down">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif


<div class="admin-card mb-4" data-aos="fade-up">
    <div class="card-body">

        <div class="row g-3">

            <div class="col-md-3">
                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Status</div>
                    @switch($gallery->status)
                        @case('published')
                            <span class="badge-himapro badge-active">Published</span>
                            @break
                        @case('draft')
                            <span class="badge-himapro badge-yellow">Draft</span>
                            @break
                        @case('archived')
                            <span class="badge-himapro badge-inactive">Archived</span>
                            @break
                    @endswitch
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Tanggal</div>
                    <div class="info-block-value">
                        {{ $gallery->tanggal?->format('d F Y') ?? '—' }}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Jumlah Foto</div>
                    <div class="info-block-value" style="color: var(--primary); font-size: 18px;">
                        {{ $gallery->items->count() }}
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Dibuat</div>
                    <div class="info-block-value" style="font-size: 12px;">
                        {{ $gallery->created_at?->format('d M Y H:i') }}
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<div class="admin-card" data-aos="fade-up" data-aos-delay="100">

    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
            <div>
                <h2 class="admin-card-title">Foto Gallery</h2>
                <p class="card-subtitle">{{ $gallery->items->count() }} foto dalam gallery ini</p>
            </div>

            @if (auth()->user()->hasPermission('gallery.create'))
                <a href="{{ route('admin.gallery.items.create', $gallery) }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Foto
                </a>
            @endif
        </div>
    </div>

    <div class="card-body">

        @if ($gallery->items->count() > 0)

            <div class="gallery-grid">

                @foreach ($gallery->items->sortBy('urutan') as $item)
                    <div class="gallery-item">

                        <div class="gallery-item-image">
                            @if ($item->file)
                                <img src="{{ asset('storage/' . $item->file) }}"
                                     alt="{{ $item->judul ?: 'Foto gallery' }}">
                            @else
                                <div class="gallery-item-placeholder">
                                    <i class="bi bi-image"></i>
                                    <span>Tidak ada foto</span>
                                </div>
                            @endif

                            <div class="gallery-item-order">#{{ $item->urutan }}</div>
                        </div>

                        <div class="gallery-item-body">
                            <h6>{{ $item->judul ?: 'Tanpa judul' }}</h6>

                            @if ($item->caption)
                                <p>{{ \Illuminate\Support\Str::limit($item->caption, 80) }}</p>
                            @else
                                <p class="italic">Tidak ada caption.</p>
                            @endif

                            <div class="gallery-item-actions">

                                @if (auth()->user()->hasPermission('gallery.update'))
                                    <a href="{{ route('admin.gallery.items.edit', [$gallery, $item]) }}"
                                       class="btn-himapro btn-himapro-secondary"
                                       style="flex: 1; justify-content: center;">
                                        <i class="bi bi-pencil"></i>
                                        Edit
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('gallery.delete'))
                                    <form action="{{ route('admin.gallery.items.destroy', [$gallery, $item]) }}"
                                          method="POST"
                                          style="flex: 1;"
                                          onsubmit="return confirm('Yakin ingin menghapus foto ini? File juga akan dihapus dari penyimpanan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn-himapro btn-himapro-danger"
                                                style="width: 100%; justify-content: center;">
                                            <i class="bi bi-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                @endif

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-images"></i>
                </div>
                <h6 class="fw-bold mb-2">Belum Ada Foto</h6>
                <p class="mb-3">Gallery ini belum memiliki foto.</p>

                @if (auth()->user()->hasPermission('gallery.create'))
                    <a href="{{ route('admin.gallery.items.create', $gallery) }}" class="btn-himapro btn-himapro-primary">
                        <i class="bi bi-plus-lg"></i>
                        Tambahkan Foto Pertama
                    </a>
                @endif
            </div>
        @endif

    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.gallery.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

@endsection