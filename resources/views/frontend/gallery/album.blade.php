@extends('layouts.app')

@section('title', $gallery->nama)
@section('meta_description', $gallery->deskripsi ?: 'Album gallery ' . $gallery->nama)

@section('content')

{{-- PAGE HEADER --}}
<section class="fe-page-header" style="padding-bottom: 40px;">
    <div class="fe-container">
        <div class="fe-page-header-content" data-aos="fade-up">
            <nav class="fe-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <a href="{{ route('frontend.gallery') }}">Gallery</a>
                <span>/</span>
                <span>{{ $gallery->nama }}</span>
            </nav>

            <div class="fe-section-label">
                <i class="bi bi-camera-fill"></i>
                {{ $gallery->items->count() }} Foto
            </div>

            <h1 class="fe-page-title">{{ $gallery->nama }}</h1>

            @if ($gallery->deskripsi)
                <p class="fe-page-desc">{{ $gallery->deskripsi }}</p>
            @endif

            @if ($gallery->tanggal)
                <div style="margin-top: 16px; font-size: 13px; color: var(--fe-muted);">
                    <i class="bi bi-calendar3"></i>
                    {{ $gallery->tanggal->format('d F Y') }}
                </div>
            @endif
        </div>
    </div>
</section>


{{-- PHOTO GRID --}}
<section class="fe-section" style="padding-top: 20px;">
    <div class="fe-container">

        @if ($gallery->items->count() > 0)

            <div class="fe-photo-grid" id="photoGrid">

                @foreach ($gallery->items as $index => $item)
                    <div
                        class="fe-photo-item"
                        data-aos="zoom-in"
                        data-aos-delay="{{ ($index % 6) * 50 }}"
                        onclick="openLightbox({{ $index }})"
                    >
                        <img
                            src="{{ asset('storage/' . $item->file) }}"
                            alt="{{ $item->judul ?: 'Foto gallery' }}"
                            loading="lazy"
                        >

                        <div class="fe-photo-overlay">
                            @if ($item->judul)
                                <div class="fe-photo-title">{{ $item->judul }}</div>
                            @endif
                            <div class="fe-photo-zoom">
                                <i class="bi bi-arrows-fullscreen"></i>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        @else

            <div class="fe-empty-state" data-aos="fade-up">
                <div class="fe-empty-icon">
                    <i class="bi bi-camera"></i>
                </div>
                <h3 class="fe-empty-title">Belum ada foto</h3>
                <p class="fe-empty-text">
                    Album ini belum memiliki foto.
                </p>
                <a href="{{ route('frontend.gallery') }}" class="fe-btn fe-btn-outline">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Gallery
                </a>
            </div>

        @endif

    </div>
</section>


{{-- LIGHTBOX --}}
<div class="fe-lightbox" id="feLightbox">
    <button class="fe-lightbox-close" onclick="closeLightbox()">
        <i class="bi bi-x-lg"></i>
    </button>

    <button class="fe-lightbox-nav fe-lightbox-prev" onclick="lightboxNav(-1)">
        <i class="bi bi-chevron-left"></i>
    </button>

    <div class="fe-lightbox-content">
        <img id="feLightboxImg" src="" alt="">
        <div class="fe-lightbox-caption" id="feLightboxCaption"></div>
    </div>

    <button class="fe-lightbox-nav fe-lightbox-next" onclick="lightboxNav(1)">
        <i class="bi bi-chevron-right"></i>
    </button>

    <div class="fe-lightbox-counter" id="feLightboxCounter"></div>
</div>


{{-- OTHER GALLERIES --}}
@if ($otherGalleries->count() > 0)
    <section class="fe-section" style="background: var(--fe-section);">
        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                <div class="fe-section-label">Album Lainnya</div>
                <h2 class="fe-section-title">
                    Lihat <span class="accent">Album Lain</span>
                </h2>
            </div>

            <div class="row g-4">

                @foreach ($otherGalleries as $index => $other)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <a href="{{ route('frontend.gallery.album', $other) }}" class="fe-album-card">
                            <div class="fe-album-cover">
                                @if ($other->cover)
                                    <img src="{{ asset('storage/' . $other->cover) }}" alt="{{ $other->nama }}">
                                @else
                                    <div class="fe-album-placeholder">
                                        <i class="bi bi-images"></i>
                                    </div>
                                @endif

                                <div class="fe-album-count">
                                    <i class="bi bi-camera-fill"></i>
                                    {{ $other->items->count() }}
                                </div>
                            </div>

                            <div class="fe-album-body">
                                <h3 class="fe-album-title">{{ $other->nama }}</h3>

                                @if ($other->tanggal)
                                    <div class="fe-album-date" style="border-top: 0; padding-top: 0;">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $other->tanggal->format('d M Y') }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @endforeach

            </div>

        </div>
    </section>
@endif


{{-- BACK --}}
<section class="fe-section-sm">
    <div class="fe-container text-center">
        <a href="{{ route('frontend.gallery') }}" class="fe-btn fe-btn-outline" data-aos="fade-up">
            <i class="bi bi-arrow-left"></i>
            Kembali ke Semua Gallery
        </a>
    </div>
</section>

@endsection


@push('styles')
<style>
/* PHOTO GRID */
.fe-photo-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.fe-photo-item {
    position: relative;
    aspect-ratio: 1;
    border-radius: var(--fe-radius-lg);
    overflow: hidden;
    background: var(--fe-card);
    border: 1px solid var(--fe-border);
    cursor: pointer;
    transition: all var(--fe-transition);
}

.fe-photo-item:hover {
    border-color: rgba(255, 210, 26, 0.4);
    transform: scale(1.02);
}

.fe-photo-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.fe-photo-item:hover img {
    transform: scale(1.08);
}

.fe-photo-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 18px;
    background: linear-gradient(to top, rgba(0, 0, 0, 0.85), transparent 60%);
    opacity: 0;
    transition: opacity var(--fe-transition);
}

.fe-photo-item:hover .fe-photo-overlay {
    opacity: 1;
}

.fe-photo-title {
    font-size: 13.5px;
    font-weight: 800;
    color: white;
    margin-bottom: 8px;
}

.fe-photo-zoom {
    align-self: flex-end;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    background: var(--fe-primary);
    color: #111;
    font-size: 14px;
}

/* LIGHTBOX */
.fe-lightbox {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.95);
    backdrop-filter: blur(8px);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 40px;
}

.fe-lightbox.open {
    display: flex;
    animation: feFadeIn 0.3s ease;
}

@keyframes feFadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.fe-lightbox-content {
    max-width: 90vw;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 16px;
}

.fe-lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    border-radius: 12px;
    object-fit: contain;
    box-shadow: 0 20px 80px rgba(0, 0, 0, 0.8);
}

.fe-lightbox-caption {
    color: white;
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    max-width: 700px;
}

.fe-lightbox-close,
.fe-lightbox-nav {
    position: absolute;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: all var(--fe-transition);
    padding: 0;
}

.fe-lightbox-close:hover,
.fe-lightbox-nav:hover {
    background: var(--fe-primary);
    color: #111;
    border-color: var(--fe-primary);
}

.fe-lightbox-close {
    top: 24px;
    right: 24px;
}

.fe-lightbox-nav {
    top: 50%;
    transform: translateY(-50%);
}

.fe-lightbox-prev { left: 24px; }
.fe-lightbox-next { right: 24px; }

.fe-lightbox-counter {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    padding: 8px 18px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: white;
    font-size: 13px;
    font-weight: 700;
}

@media (max-width: 767.98px) {
    .fe-photo-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    .fe-lightbox {
        padding: 16px;
    }
    .fe-lightbox-close {
        top: 12px;
        right: 12px;
        width: 40px;
        height: 40px;
    }
    .fe-lightbox-prev { left: 8px; }
    .fe-lightbox-next { right: 8px; }
    .fe-lightbox-nav {
        width: 40px;
        height: 40px;
    }
}
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const photos = @json($gallery->items->map(fn ($item) => [
        'src' => asset('storage/' . $item->file),
        'title' => $item->judul,
        'caption' => $item->caption,
    ])->values());

    const lightbox = document.getElementById('feLightbox');
    const lightboxImg = document.getElementById('feLightboxImg');
    const lightboxCaption = document.getElementById('feLightboxCaption');
    const lightboxCounter = document.getElementById('feLightboxCounter');

    let currentIndex = 0;

    window.openLightbox = function (index) {
        currentIndex = index;
        updateLightbox();
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.closeLightbox = function () {
        lightbox.classList.remove('open');
        document.body.style.overflow = '';
    };

    window.lightboxNav = function (direction) {
        currentIndex += direction;
        if (currentIndex < 0) currentIndex = photos.length - 1;
        if (currentIndex >= photos.length) currentIndex = 0;
        updateLightbox();
    };

    function updateLightbox() {
        const photo = photos[currentIndex];
        if (!photo) return;

        lightboxImg.src = photo.src;
        lightboxImg.alt = photo.title || '';

        const captionParts = [];
        if (photo.title) captionParts.push(photo.title);
        if (photo.caption) captionParts.push(photo.caption);
        lightboxCaption.textContent = captionParts.join(' — ');

        lightboxCounter.textContent = (currentIndex + 1) + ' / ' + photos.length;
    }

    // ESC & arrow keys
    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('open')) return;

        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') lightboxNav(-1);
        if (e.key === 'ArrowRight') lightboxNav(1);
    });

    // Klik backdrop untuk close
    lightbox?.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });

});
</script>
@endpush