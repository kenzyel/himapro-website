@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', $sections->get('hero')?->content['description'] ?? 'HIMAPRO TI SAKTI — Himpunan Mahasiswa Program Studi Teknologi Informasi.')

@section('content')

@php
    $hero = $sections->get('hero');
    $about = $sections->get('about');
    $progker = $sections->get('program_kerja');
    $agendaSec = $sections->get('agenda');
    $pengumumanSec = $sections->get('pengumuman');
    $gallerySec = $sections->get('gallery');
    $partnerSec = $sections->get('partner');
    $ctaSec = $sections->get('cta');
@endphp

{{-- =========================================================
     SECTION 1: HERO BOLD + PARTICLE
     ========================================================= --}}
@if ($hero)
    @php
        $h = $hero->content;
        $allCards = $h['floating_cards'] ?? [];
        $activeCards = collect($allCards)->where('is_active', true)->take(3)->values();
    @endphp

    <section class="fe-hero">

        <div class="fe-hero-bg"></div>

        {{-- Particle container --}}
        <div class="fe-particles"></div>

        <div class="fe-hero-orb fe-hero-orb-1"></div>
        <div class="fe-hero-orb fe-hero-orb-2"></div>
        <div class="fe-hero-orb fe-hero-orb-3"></div>

        <div class="fe-container">

            <div class="row align-items-center g-5">

                <div class="col-lg-7">

                    @if (! empty($h['label']))
                        <div class="fe-section-label" data-aos="fade-up">
                            {{ $h['label'] }}
                        </div>
                    @endif

                    <h1 class="fe-hero-title" data-aos="fade-up" data-aos-delay="100">
                        {!! $h['title'] ?? '' !!}
                    </h1>

                    <p class="fe-hero-desc" data-aos="fade-up" data-aos-delay="200">
                        {{ $h['description'] ?? '' }}
                    </p>

                    <div class="d-flex gap-3 flex-wrap" data-aos="fade-up" data-aos-delay="300">

                        @if (! empty($h['cta1_text']))
                            <a href="{{ $h['cta1_link'] ?? '#' }}" class="fe-btn fe-btn-primary fe-btn-lg">
                                @if (! empty($h['cta1_icon']))
                                    <i class="bi {{ $h['cta1_icon'] }}"></i>
                                @endif
                                {{ $h['cta1_text'] }}
                            </a>
                        @endif

                        @if (! empty($h['cta2_text']))
                            <a href="{{ $h['cta2_link'] ?? '#' }}" class="fe-btn fe-btn-outline fe-btn-lg">
                                @if (! empty($h['cta2_icon']))
                                    <i class="bi {{ $h['cta2_icon'] }}"></i>
                                @endif
                                {{ $h['cta2_text'] }}
                            </a>
                        @endif

                    </div>

                    @if (($h['show_stats'] ?? true) == 1)
                        <div class="fe-hero-stats" data-aos="fade-up" data-aos-delay="400">

                            <div class="fe-hero-stat">
                                <div class="fe-hero-stat-value fe-counter" data-countup="{{ $stats['pengurus'] }}">0</div>
                                <div class="fe-hero-stat-label">Pengurus Aktif</div>
                            </div>

                            <div class="fe-hero-stat">
                                <div class="fe-hero-stat-value fe-counter" data-countup="{{ $stats['departemen'] }}">0</div>
                                <div class="fe-hero-stat-label">Departemen</div>
                            </div>

                            <div class="fe-hero-stat">
                                <div class="fe-hero-stat-value fe-counter" data-countup="{{ $stats['program_kerja'] }}">0</div>
                                <div class="fe-hero-stat-label">Program Kerja</div>
                            </div>

                            <div class="fe-hero-stat">
                                <div class="fe-hero-stat-value fe-counter" data-countup="{{ $stats['agenda'] }}">0</div>
                                <div class="fe-hero-stat-label">Agenda</div>
                            </div>

                        </div>
                    @endif

                </div>

                @if ($activeCards->count() > 0)
                    <div class="col-lg-5 d-none d-lg-block">

                        <div class="fe-hero-visual" data-aos="fade-left" data-aos-delay="300">

                            @foreach ($activeCards as $index => $card)
                                <div class="fe-hero-card fe-hero-card-{{ $index + 1 }} fe-float" style="animation-delay: {{ $index * 2 }}s;">
                                    <div class="fe-hero-card-icon fe-color-{{ $card['color'] ?? 'primary' }}">
                                        <i class="bi {{ $card['icon'] ?? 'bi-star-fill' }}"></i>
                                    </div>
                                    <div>
                                        <div class="fe-hero-card-title">{{ $card['title'] ?? '' }}</div>
                                        <div class="fe-hero-card-text">{{ $card['description'] ?? '' }}</div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                @endif

            </div>

        </div>

    </section>
@endif


{{-- =========================================================
     SECTION 2: ABOUT
     ========================================================= --}}
@if ($about)
    @php
        $a = $about->content;
        $features = $a['features'] ?? [];
    @endphp

    <section class="fe-section" id="about">
        <div class="fe-container">

            <div class="row align-items-center g-5">

                <div class="col-lg-6" data-aos="fade-right">

                    @if (! empty($a['label']))
                        <div class="fe-section-label">{{ $a['label'] }}</div>
                    @endif

                    <h2 class="fe-section-title" style="text-align: left; font-size: 42px; margin-bottom: 24px;">
                        {!! $a['title'] ?? '' !!}
                    </h2>

                    <p class="fe-section-desc" style="text-align: left; margin: 0 0 32px; max-width: 100%;">
                        {{ $a['description'] ?? '' }}
                    </p>

                    @if (count($features) > 0)
                        <div class="fe-about-list">

                            @foreach ($features as $f)
                                <div class="fe-about-item fe-tilt">
                                    <div class="fe-about-icon">
                                        <i class="bi {{ $f['icon'] ?? 'bi-check-lg' }}"></i>
                                    </div>
                                    <div>
                                        <div class="fe-about-title">{{ $f['title'] ?? '' }}</div>
                                        <div class="fe-about-text">{{ $f['description'] ?? '' }}</div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    @endif

                    <div class="d-flex gap-3 mt-5 flex-wrap">
                        <a href="{{ route('frontend.about') }}" class="fe-btn fe-btn-primary">
                            <i class="bi bi-info-circle"></i>
                            Selengkapnya
                        </a>
                        <a href="{{ route('frontend.struktur') }}" class="fe-btn fe-btn-outline">
                            <i class="bi bi-diagram-3"></i>
                            Lihat Struktur
                        </a>
                    </div>

                </div>

                <div class="col-lg-6" data-aos="fade-left">

                    <div class="fe-about-visual">

                        <div class="fe-about-block fe-about-block-1">
                            <i class="bi bi-quote"></i>
                            <div class="fe-about-block-text">
                                "{{ $a['quote'] ?? '' }}"
                            </div>
                            <div class="fe-about-block-author">— {{ $a['quote_author'] ?? '' }}</div>
                        </div>

                        <div class="fe-about-block fe-about-block-2">
                            <div class="fe-about-block-value fe-counter">{{ $a['stat1_value'] ?? '' }}</div>
                            <div class="fe-about-block-label">{{ $a['stat1_label'] ?? '' }}</div>
                        </div>

                        <div class="fe-about-block fe-about-block-3">
                            <div class="fe-about-block-value fe-counter">{{ $a['stat2_value'] ?? '' }}</div>
                            <div class="fe-about-block-label">{{ $a['stat2_label'] ?? '' }}</div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>
@endif


{{-- =========================================================
     SECTION 3: PROGRAM KERJA
     ========================================================= --}}
@if ($progker && $programKerjas->count() > 0)
    @php $pk = $progker->content; @endphp

    <section class="fe-section" style="background: var(--fe-section);">

        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                @if (! empty($pk['label']))
                    <div class="fe-section-label">{{ $pk['label'] }}</div>
                @endif

                <h2 class="fe-section-title">
                    {!! $pk['title'] ?? '' !!}
                </h2>

                @if (! empty($pk['description']))
                    <p class="fe-section-desc">
                        {{ $pk['description'] }}
                    </p>
                @endif
            </div>

            <div class="row g-4">

                @foreach ($programKerjas as $index => $programKerja)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                        <div class="fe-card fe-tilt fe-card-program">

                            <div class="fe-card-icon">
                                <i class="bi bi-kanban-fill"></i>
                            </div>

                            @if ($programKerja->departemen)
                                <span class="fe-badge fe-badge-primary" style="margin-bottom: 14px; display: inline-block;">
                                    {{ $programKerja->departemen->nama }}
                                </span>
                            @endif

                            <h3 class="fe-card-title">
                                {{ $programKerja->nama }}
                            </h3>

                            <p class="fe-card-text">
                                {{ \Illuminate\Support\Str::limit($programKerja->deskripsi ?: 'Program kerja HIMAPRO TI SAKTI.', 110) }}
                            </p>

                            <div class="fe-card-footer">
                                <span class="fe-card-meta">
                                    <i class="bi bi-calendar3"></i>
                                    {{ $programKerja->periode }}
                                </span>

                                @switch($programKerja->status)
                                    @case('planned')
                                        <span class="fe-badge fe-badge-primary">Direncanakan</span>
                                        @break
                                    @case('ongoing')
                                        <span class="fe-badge fe-badge-info">Berjalan</span>
                                        @break
                                    @case('completed')
                                        <span class="fe-badge fe-badge-success">Selesai</span>
                                        @break
                                    @case('cancelled')
                                        <span class="fe-badge" style="background: rgba(239,68,68,.12); color: #fca5a5; border-color: rgba(239,68,68,.25);">
                                            Dibatalkan
                                        </span>
                                        @break
                                @endswitch
                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </section>
@endif


{{-- =========================================================
     SECTION 4: AGENDA
     ========================================================= --}}
@if ($agendaSec && $agendas->count() > 0)
    @php $ag = $agendaSec->content; @endphp

    <section class="fe-section">

        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                @if (! empty($ag['label']))
                    <div class="fe-section-label">{{ $ag['label'] }}</div>
                @endif

                <h2 class="fe-section-title">
                    {!! $ag['title'] ?? '' !!}
                </h2>

                @if (! empty($ag['description']))
                    <p class="fe-section-desc">{{ $ag['description'] }}</p>
                @endif
            </div>

            <div class="row g-4">

                @foreach ($agendas as $index => $agenda)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">

                        <div class="fe-card fe-tilt fe-card-agenda">

                            <div class="fe-agenda-top">

                                <div class="fe-agenda-date">
                                    <div class="fe-agenda-day">
                                        {{ $agenda->tanggal_mulai?->format('d') }}
                                    </div>
                                    <div class="fe-agenda-month">
                                        {{ $agenda->tanggal_mulai?->format('M') }}
                                    </div>
                                    <div class="fe-agenda-year">
                                        {{ $agenda->tanggal_mulai?->format('Y') }}
                                    </div>
                                </div>

                                <div style="flex: 1;">
                                    <h3 class="fe-card-title" style="margin-bottom: 8px;">
                                        {{ $agenda->judul }}
                                    </h3>

                                    @if ($agenda->lokasi)
                                        <div class="fe-agenda-meta">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ $agenda->lokasi }}
                                        </div>
                                    @endif

                                    <div class="fe-agenda-meta">
                                        <i class="bi bi-clock"></i>
                                        {{ $agenda->tanggal_mulai?->format('H:i') }}
                                        @if ($agenda->tanggal_selesai)
                                            – {{ $agenda->tanggal_selesai->format('H:i') }}
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <p class="fe-card-text">
                                {{ \Illuminate\Support\Str::limit($agenda->deskripsi ?: 'Agenda kegiatan HIMAPRO TI SAKTI.', 100) }}
                            </p>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </section>
@endif


{{-- =========================================================
     SECTION 5: PENGUMUMAN — MAJALAH
     ========================================================= --}}
@if ($pengumumanSec && $pengumumans->count() > 0)
    @php $pg = $pengumumanSec->content; @endphp

    <section class="fe-section" style="background: var(--fe-section);">

        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                @if (! empty($pg['label']))
                    <div class="fe-section-label">{{ $pg['label'] }}</div>
                @endif

                <h2 class="fe-section-title">
                    {!! $pg['title'] ?? '' !!}
                </h2>

                @if (! empty($pg['description']))
                    <p class="fe-section-desc">{{ $pg['description'] }}</p>
                @endif
            </div>

            <div class="fe-magazine">

                @foreach ($pengumumans as $index => $pengumuman)
                    <div
                        class="fe-magazine-item {{ $index === 0 ? 'featured' : '' }}"
                        data-aos="fade-up"
                        data-aos-delay="{{ $index * 100 }}"
                    >

                        <div class="fe-magazine-badge">
                            <span class="fe-badge fe-badge-primary">
                                <i class="bi bi-megaphone-fill"></i>
                                Pengumuman
                            </span>
                        </div>

                        <div class="fe-magazine-date">
                            <i class="bi bi-calendar3"></i>
                            {{ $pengumuman->published_at?->format('d M Y') ?? $pengumuman->created_at?->format('d M Y') }}
                        </div>

                        <h3 class="fe-magazine-title">
                            {{ $pengumuman->judul }}
                        </h3>

                        <p class="fe-magazine-text">
                            {{ \Illuminate\Support\Str::limit($pengumuman->ringkasan ?: $pengumuman->isi, $index === 0 ? 220 : 120) }}
                        </p>

                    </div>
                @endforeach

            </div>

        </div>

    </section>
@endif


{{-- =========================================================
     SECTION 6: GALLERY — MASONRY
     ========================================================= --}}
@if ($gallerySec && $galleries->count() > 0)
    @php $gl = $gallerySec->content; @endphp

    <section class="fe-section">

        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                @if (! empty($gl['label']))
                    <div class="fe-section-label">{{ $gl['label'] }}</div>
                @endif

                <h2 class="fe-section-title">
                    {!! $gl['title'] ?? '' !!}
                </h2>

                @if (! empty($gl['description']))
                    <p class="fe-section-desc">{{ $gl['description'] }}</p>
                @endif
            </div>

            <div class="fe-gallery-masonry">

                @foreach ($galleries as $index => $gallery)
                    <a
                        href="{{ route('frontend.gallery.album', $gallery) }}"
                        class="fe-gallery-masonry-item {{ $index === 0 ? 'featured' : '' }}"
                        data-aos="zoom-in"
                        data-aos-delay="{{ $index * 80 }}"
                    >
                        @if ($gallery->cover)
                            <img src="{{ asset('storage/' . $gallery->cover) }}" alt="{{ $gallery->nama }}">
                        @else
                            <div class="fe-gallery-placeholder">
                                <i class="bi bi-images"></i>
                            </div>
                        @endif

                        <div class="fe-gallery-overlay">
                            <div class="fe-gallery-title">{{ $gallery->nama }}</div>
                            <div class="fe-gallery-count">
                                <i class="bi bi-camera"></i>
                                {{ $gallery->items->count() }} foto
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>

            @if (($gl['show_cta'] ?? true) == 1)
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ $gl['cta_link'] ?? route('frontend.gallery') }}" class="fe-btn fe-btn-outline">
                        <i class="bi bi-images"></i>
                        {{ $gl['cta_text'] ?? 'Lihat Semua Gallery' }}
                    </a>
                </div>
            @endif

        </div>

    </section>
@endif


{{-- =========================================================
     SECTION 7: PARTNER
     ========================================================= --}}
@if ($partnerSec && $partners->count() > 0)
    @php $pr = $partnerSec->content; @endphp

    <section class="fe-section-sm fe-partner-section">

        <div class="fe-container">

            <div class="text-center mb-5" data-aos="fade-up">
                @if (! empty($pr['label']))
                    <div class="fe-section-label">{{ $pr['label'] }}</div>
                @endif
                <h3 class="fe-partner-heading">
                    {{ $pr['title'] ?? '' }}
                </h3>
            </div>

            <div class="fe-partners">

                @foreach ($partners as $partner)
                    <div class="fe-partner-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">

                        @if ($partner->website)
                            <a href="{{ $partner->website }}" target="_blank" class="fe-partner-link">
                                @if ($partner->logo)
                                    <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->nama }}">
                                @else
                                    <span class="fe-partner-name">{{ $partner->nama }}</span>
                                @endif
                            </a>
                        @else
                            @if ($partner->logo)
                                <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->nama }}">
                            @else
                                <span class="fe-partner-name">{{ $partner->nama }}</span>
                            @endif
                        @endif

                    </div>
                @endforeach

            </div>

        </div>

    </section>
@endif


{{-- =========================================================
     SECTION 8: CTA DRAMATIS
     ========================================================= --}}
@if ($ctaSec)
    @php $ct = $ctaSec->content; @endphp

    <section class="fe-cta-section">

        <div class="fe-container">

            <div class="fe-cta fe-cta-dramatic" data-aos="zoom-in">

                <div class="fe-cta-orb fe-cta-orb-1"></div>
                <div class="fe-cta-orb fe-cta-orb-2"></div>

                <div class="fe-cta-content">

                    @if (! empty($ct['label']))
                        <div class="fe-section-label" style="margin-bottom: 22px;">
                            {{ $ct['label'] }}
                        </div>
                    @endif

                    <h2 class="fe-cta-title">
                        {!! $ct['title'] ?? '' !!}
                    </h2>

                    @if (! empty($ct['description']))
                        <p class="fe-cta-desc">
                            {{ $ct['description'] }}
                        </p>
                    @endif

                    <div class="d-flex gap-3 justify-content-center flex-wrap">

                        @if (! empty($ct['cta1_text']))
                            <a href="{{ $ct['cta1_link'] ?? '#' }}" class="fe-btn fe-btn-primary fe-btn-lg">
                                @if (! empty($ct['cta1_icon']))
                                    <i class="bi {{ $ct['cta1_icon'] }}"></i>
                                @endif
                                {{ $ct['cta1_text'] }}
                            </a>
                        @endif

                        @if (! empty($ct['cta2_text']))
                            <a href="{{ $ct['cta2_link'] ?? '#' }}" class="fe-btn fe-btn-outline fe-btn-lg">
                                @if (! empty($ct['cta2_icon']))
                                    <i class="bi {{ $ct['cta2_icon'] }}"></i>
                                @endif
                                {{ $ct['cta2_text'] }}
                            </a>
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </section>
@endif

@endsection