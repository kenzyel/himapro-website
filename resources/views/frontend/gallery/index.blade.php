@extends('layouts.app')

@section('title', 'Gallery')
@section('meta_description', 'Dokumentasi kegiatan dan momen HIMAPRO TI SAKTI.')

@section('content')

{{-- PAGE HEADER --}}
<section class="fe-page-header">
    <div class="fe-container">
        <div class="fe-page-header-content" data-aos="fade-up">
            <nav class="fe-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <span>Gallery</span>
            </nav>

            <div class="fe-section-label">Gallery</div>

            <h1 class="fe-page-title">
                Momen <span class="accent">Berharga</span> Kami
            </h1>

            <p class="fe-page-desc">
                Dokumentasi kegiatan, kebersamaan, dan cerita di balik setiap program HIMAPRO TI SAKTI.
            </p>
        </div>
    </div>
</section>


{{-- SEARCH + GRID --}}
<section class="fe-section" style="padding-top: 40px;">
    <div class="fe-container">

        {{-- SEARCH --}}
        <div class="fe-gallery-search" data-aos="fade-up">
            <form method="GET" action="{{ route('frontend.gallery') }}">
                <div class="fe-search-box">
                    <i class="bi bi-search"></i>
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari album gallery..."
                        value="{{ request('search') }}"
                    >
                    @if (request('search'))
                        <a href="{{ route('frontend.gallery') }}" class="fe-search-clear">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>


        {{-- GRID --}}
        @if ($galleries->count() > 0)

            <div class="fe-album-grid">

                @foreach ($galleries as $index => $gallery)
                    <a
                        href="{{ route('frontend.gallery.album', $gallery) }}"
                        class="fe-album-card"
                        data-aos="fade-up"
                        data-aos-delay="{{ ($index % 3) * 100 }}"
                    >
                        <div class="fe-album-cover">
                            @if ($gallery->cover)
                                <img src="{{ asset('storage/' . $gallery->cover) }}" alt="{{ $gallery->nama }}">
                            @else
                                <div class="fe-album-placeholder">
                                    <i class="bi bi-images"></i>
                                </div>
                            @endif

                            <div class="fe-album-overlay">
                                <span class="fe-album-view">
                                    <i class="bi bi-eye"></i>
                                    Lihat Album
                                </span>
                            </div>

                            <div class="fe-album-count">
                                <i class="bi bi-camera-fill"></i>
                                {{ $gallery->items->count() }}
                            </div>
                        </div>

                        <div class="fe-album-body">
                            <h3 class="fe-album-title">{{ $gallery->nama }}</h3>

                            @if ($gallery->deskripsi)
                                <p class="fe-album-desc">
                                    {{ \Illuminate\Support\Str::limit($gallery->deskripsi, 100) }}
                                </p>
                            @endif

                            <div class="fe-album-date">
                                <i class="bi bi-calendar3"></i>
                                {{ $gallery->tanggal?->format('d M Y') ?? $gallery->created_at->format('d M Y') }}
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>


            {{-- PAGINATION --}}
            @if ($galleries->hasPages())
                <div class="fe-pagination" data-aos="fade-up">
                    {{ $galleries->links() }}
                </div>
            @endif

        @else

            {{-- EMPTY --}}
            <div class="fe-empty-state" data-aos="fade-up">
                <div class="fe-empty-icon">
                    <i class="bi bi-images"></i>
                </div>

                @if (request('search'))
                    <h3 class="fe-empty-title">Tidak ditemukan</h3>
                    <p class="fe-empty-text">
                        Tidak ada album gallery yang cocok dengan "{{ request('search') }}".
                    </p>
                    <a href="{{ route('frontend.gallery') }}" class="fe-btn fe-btn-outline">
                        <i class="bi bi-arrow-counterclockwise"></i>
                        Reset Pencarian
                    </a>
                @else
                    <h3 class="fe-empty-title">Belum ada gallery</h3>
                    <p class="fe-empty-text">
                        Gallery akan muncul setelah admin menambahkan album.
                    </p>
                @endif
            </div>

        @endif

    </div>
</section>


@push('styles')
<style>
.fe-gallery-search {
    max-width: 600px;
    margin: 0 auto 50px;
}

.fe-search-box {
    position: relative;
    display: flex;
    align-items: center;
}

.fe-search-box i {
    position: absolute;
    left: 20px;
    color: var(--fe-muted);
    font-size: 18px;
    pointer-events: none;
}

.fe-search-box input {
    width: 100%;
    padding: 16px 50px 16px 52px;
    border-radius: 14px;
    background: var(--fe-card);
    border: 1px solid var(--fe-border);
    color: var(--fe-text);
    font-size: 14.5px;
    font-family: inherit;
    outline: none;
    transition: all var(--fe-transition);
}

.fe-search-box input::placeholder {
    color: var(--fe-muted);
}

.fe-search-box input:focus {
    border-color: var(--fe-primary);
    box-shadow: 0 0 0 4px rgba(255, 210, 26, 0.1);
}

.fe-search-clear {
    position: absolute;
    right: 16px;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.05);
    color: var(--fe-muted);
    font-size: 12px;
    transition: all var(--fe-transition);
}

.fe-search-clear:hover {
    background: rgba(239, 68, 68, 0.15);
    color: #fca5a5;
}

/* ALBUM GRID */
.fe-album-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}

.fe-album-card {
    display: block;
    border-radius: var(--fe-radius-lg);
    background: var(--fe-card);
    border: 1px solid var(--fe-border);
    overflow: hidden;
    transition: all var(--fe-transition);
    text-decoration: none;
    color: inherit;
}

.fe-album-card:hover {
    border-color: rgba(255, 210, 26, 0.4);
    transform: translateY(-6px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.fe-album-cover {
    position: relative;
    width: 100%;
    aspect-ratio: 4/3;
    background: var(--fe-section);
    overflow: hidden;
}

.fe-album-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.fe-album-card:hover .fe-album-cover img {
    transform: scale(1.08);
}

.fe-album-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--fe-card), var(--fe-section));
    color: var(--fe-muted);
    font-size: 56px;
}

.fe-album-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.6);
    opacity: 0;
    transition: opacity var(--fe-transition);
}

.fe-album-card:hover .fe-album-overlay {
    opacity: 1;
}

.fe-album-view {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: 999px;
    background: var(--fe-primary);
    color: #111;
    font-size: 13px;
    font-weight: 800;
    transform: translateY(10px);
    transition: transform var(--fe-transition);
}

.fe-album-card:hover .fe-album-view {
    transform: translateY(0);
}

.fe-album-count {
    position: absolute;
    top: 14px;
    right: 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 999px;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
    color: var(--fe-primary);
    font-size: 11.5px;
    font-weight: 800;
    border: 1px solid rgba(255, 210, 26, 0.3);
}

.fe-album-body {
    padding: 22px;
}

.fe-album-title {
    font-size: 17px;
    font-weight: 800;
    margin: 0 0 8px;
    letter-spacing: -0.01em;
    line-height: 1.3;
}

.fe-album-desc {
    font-size: 13px;
    color: var(--fe-muted);
    line-height: 1.6;
    margin: 0 0 14px;
}

.fe-album-date {
    font-size: 11.5px;
    color: var(--fe-muted);
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding-top: 14px;
    border-top: 1px solid var(--fe-border);
    width: 100%;
}

/* PAGINATION */
.fe-pagination {
    display: flex;
    justify-content: center;
    margin-top: 50px;
}

.fe-pagination .pagination {
    gap: 6px;
}

.fe-pagination .page-link {
    background: var(--fe-card);
    border: 1px solid var(--fe-border);
    color: var(--fe-text);
    border-radius: 10px !important;
    padding: 9px 14px;
    font-size: 13px;
    font-weight: 700;
    transition: all var(--fe-transition);
}

.fe-pagination .page-link:hover {
    background: rgba(255, 210, 26, 0.1);
    border-color: rgba(255, 210, 26, 0.4);
    color: var(--fe-primary);
}

.fe-pagination .page-item.active .page-link {
    background: var(--fe-primary);
    border-color: var(--fe-primary);
    color: #111;
    box-shadow: 0 4px 16px rgba(255, 210, 26, 0.35);
}

/* EMPTY STATE */
.fe-empty-state {
    text-align: center;
    padding: 80px 20px;
    max-width: 500px;
    margin: 0 auto;
}

.fe-empty-icon {
    width: 100px;
    height: 100px;
    margin: 0 auto 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 24px;
    background: rgba(255, 210, 26, 0.08);
    border: 1px solid rgba(255, 210, 26, 0.2);
    color: var(--fe-primary);
    font-size: 42px;
}

.fe-empty-title {
    font-size: 22px;
    font-weight: 800;
    margin-bottom: 10px;
    letter-spacing: -0.01em;
}

.fe-empty-text {
    font-size: 14px;
    color: var(--fe-muted);
    line-height: 1.7;
    margin-bottom: 24px;
}

@media (max-width: 991.98px) {
    .fe-album-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575.98px) {
    .fe-album-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@endsection