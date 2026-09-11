@extends('layouts.app')

@section('title', 'Visi & Misi')

@php
    $c = $section->content ?? [];
    $misi = $c['misi'] ?? [];
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
                <span>Visi & Misi</span>
            </nav>

            <div class="fe-section-label">Visi & Misi</div>

            <h1 class="fe-page-title">
                {!! $c['title'] ?? 'Arah & Tujuan Kami' !!}
            </h1>

            @if (! empty($c['description']))
                <p class="fe-page-desc">{{ $c['description'] }}</p>
            @endif
        </div>
    </div>
</section>


{{-- VISI --}}
@if (! empty($c['visi']))
    <section class="fe-section">
        <div class="fe-container">

            <div class="fe-visi-card" data-aos="fade-up">

                <div class="fe-visi-label">Visi</div>

                <div class="fe-visi-quote">
                    <i class="bi bi-quote"></i>
                </div>

                <h2 class="fe-visi-text">
                    {!! $c['visi'] !!}
                </h2>

            </div>

        </div>
    </section>
@endif


{{-- MISI --}}
@if (count($misi) > 0)
    <section class="fe-section" style="background: var(--fe-section);">
        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                <div class="fe-section-label">Misi</div>
                <h2 class="fe-section-title">
                    Misi <span class="accent">Kami</span>
                </h2>
                <p class="fe-section-desc">
                    Langkah nyata yang kami tempuh untuk mewujudkan visi.
                </p>
            </div>

            <div class="row g-4">

                @foreach ($misi as $index => $m)
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="{{ ($index % 2) * 100 }}">
                        <div class="fe-misi-item">
                            <div class="fe-misi-number">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</div>
                            <div>
                                <h3 class="fe-misi-title">{{ $m['title'] ?? '' }}</h3>
                                <p class="fe-misi-text">{{ $m['description'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>
@endif

@endsection


@push('styles')
<style>
.fe-visi-card {
    position: relative;
    max-width: 900px;
    margin: 0 auto;
    padding: 60px 50px;
    border-radius: var(--fe-radius-xl);
    background: linear-gradient(135deg, rgba(255, 210, 26, 0.08), rgba(245, 169, 0, 0.04));
    border: 1px solid rgba(255, 210, 26, 0.25);
    text-align: center;
    overflow: hidden;
}

.fe-visi-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 30%;
    right: 30%;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--fe-primary), transparent);
}

.fe-visi-label {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 999px;
    background: var(--fe-primary);
    color: #111;
    font-size: 11px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    margin-bottom: 20px;
}

.fe-visi-quote {
    font-size: 60px;
    color: var(--fe-primary);
    opacity: 0.3;
    line-height: 1;
    margin-bottom: 12px;
}

.fe-visi-text {
    font-size: 26px;
    font-weight: 700;
    line-height: 1.5;
    letter-spacing: -0.02em;
    margin: 0;
    font-family: var(--font-display);
}

.fe-misi-item {
    display: flex;
    gap: 22px;
    padding: 28px;
    border-radius: var(--fe-radius-lg);
    background: var(--fe-card);
    border: 1px solid var(--fe-border);
    height: 100%;
    transition: all var(--fe-transition);
}

.fe-misi-item:hover {
    border-color: rgba(255, 210, 26, 0.3);
    transform: translateY(-4px);
    box-shadow: 0 16px 48px rgba(0, 0, 0, 0.5);
}

.fe-misi-number {
    font-size: 32px;
    font-weight: 900;
    color: var(--fe-primary);
    line-height: 1;
    letter-spacing: -0.03em;
    flex-shrink: 0;
    opacity: 0.6;
    font-family: var(--font-display);
}

.fe-misi-title {
    font-size: 16px;
    font-weight: 800;
    margin-bottom: 10px;
    font-family: var(--font-display);
}

.fe-misi-text {
    font-size: 13.5px;
    color: var(--fe-muted);
    line-height: 1.7;
    margin: 0;
}

@media (max-width: 767.98px) {
    .fe-visi-card { padding: 40px 24px; }
    .fe-visi-text { font-size: 19px; }
    .fe-misi-number { font-size: 24px; }
}
</style>
@endpush