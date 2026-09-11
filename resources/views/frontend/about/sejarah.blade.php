@extends('layouts.app')

@section('title', 'Sejarah')

@php
    $c = $section->content ?? [];
    $timeline = $c['timeline'] ?? [];
@endphp

@section('content')

{{-- PAGE HEADER --}}
<section class="fe-page-header">
    <div class="fe-container">
        <div class="fe-page-header-content" data-aos="fade-up">
            <nav class="fe-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <a href="{{ route('frontend.about') }}">Tentang</a>
                <span>/</span>
                <span>Sejarah</span>
            </nav>

            <div class="fe-section-label">Sejarah</div>

            <h1 class="fe-page-title">
                {!! $c['title'] ?? 'Perjalanan Kami' !!}
            </h1>

            @if (! empty($c['description']))
                <p class="fe-page-desc">{{ $c['description'] }}</p>
            @endif
        </div>
    </div>
</section>


{{-- INTRO --}}
@if (! empty($c['intro']))
    <section class="fe-section-sm">
        <div class="fe-container">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;" data-aos="fade-up">
                <p style="font-size: 16px; color: var(--fe-muted); line-height: 1.9; margin: 0;">
                    {{ $c['intro'] }}
                </p>
            </div>
        </div>
    </section>
@endif


{{-- TIMELINE --}}
@if (count($timeline) > 0)
    <section class="fe-section">
        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                @if (! empty($c['timeline_label']))
                    <div class="fe-section-label">{{ $c['timeline_label'] }}</div>
                @endif

                <h2 class="fe-section-title">
                    {!! $c['timeline_title'] ?? 'Tonggak Perjalanan' !!}
                </h2>
            </div>

            <div class="fe-timeline">

                @foreach ($timeline as $index => $t)
                    <div class="fe-timeline-item" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="fe-timeline-dot"></div>
                        <div class="fe-timeline-content">
                            @if (! empty($t['year']))
                                <div class="fe-timeline-year">{{ $t['year'] }}</div>
                            @endif

                            @if (! empty($t['title']))
                                <h3 class="fe-timeline-title">{{ $t['title'] }}</h3>
                            @endif

                            @if (! empty($t['description']))
                                <p class="fe-timeline-text">{{ $t['description'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>
@endif


{{-- CTA --}}
<section class="fe-cta-section" style="padding-top: 0;">
    <div class="fe-container">
        <div class="fe-cta fe-cta-dramatic" data-aos="zoom-in">

            <div class="fe-cta-orb fe-cta-orb-1"></div>
            <div class="fe-cta-orb fe-cta-orb-2"></div>

            <div class="fe-cta-content">
                <h2 class="fe-cta-title">
                    Jadi Bagian dari <span class="accent">Cerita Kami</span>
                </h2>

                <p class="fe-cta-desc">
                    Bergabunglah dan tulis sejarah baru bersama HIMAPRO TI SAKTI.
                </p>

                <a href="{{ route('frontend.contact') }}" class="fe-btn fe-btn-primary fe-btn-lg">
                    <i class="bi bi-arrow-right"></i>
                    Hubungi Kami
                </a>
            </div>

        </div>
    </div>
</section>

@endsection


@push('styles')
<style>
.fe-timeline {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
    padding-left: 40px;
}

.fe-timeline::before {
    content: '';
    position: absolute;
    left: 11px;
    top: 20px;
    bottom: 20px;
    width: 2px;
    background: linear-gradient(to bottom, var(--fe-primary), transparent);
}

.fe-timeline-item {
    position: relative;
    padding-bottom: 44px;
}

.fe-timeline-item:last-child {
    padding-bottom: 0;
}

.fe-timeline-dot {
    position: absolute;
    left: -40px;
    top: 6px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: var(--fe-primary);
    border: 4px solid var(--fe-bg);
    box-shadow: 0 0 0 2px var(--fe-primary), 0 0 20px rgba(255, 210, 26, 0.5);
}

.fe-timeline-year {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 999px;
    background: rgba(255, 210, 26, 0.1);
    border: 1px solid rgba(255, 210, 26, 0.25);
    color: var(--fe-primary);
    font-size: 10.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 12px;
}

.fe-timeline-title {
    font-size: 20px;
    font-weight: 800;
    margin-bottom: 10px;
    font-family: var(--font-display);
    letter-spacing: -0.01em;
}

.fe-timeline-text {
    font-size: 14px;
    color: var(--fe-muted);
    line-height: 1.8;
    margin: 0;
}

@media (max-width: 767.98px) {
    .fe-timeline { padding-left: 30px; }
    .fe-timeline::before { left: 9px; }
    .fe-timeline-dot { left: -30px; width: 20px; height: 20px; }
    .fe-timeline-title { font-size: 16px; }
}
</style>
@endpush