@extends('layouts.app')

@section('title', 'Tentang Kami')

@php
    $c = $section->content ?? [];
    $paragraphs = $c['intro_paragraphs'] ?? [];
    $values = $c['values'] ?? [];
@endphp

@section('content')

{{-- PAGE HEADER --}}
<section class="fe-page-header">
    <div class="fe-container">
        <div class="fe-page-header-content" data-aos="fade-up">
            <nav class="fe-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <span>Tentang</span>
            </nav>

            <div class="fe-section-label">Tentang Kami</div>

            <h1 class="fe-page-title">
                {!! $c['title'] ?? 'Kenali HIMAPRO TI SAKTI' !!}
            </h1>

            @if (! empty($c['description']))
                <p class="fe-page-desc">{{ $c['description'] }}</p>
            @endif
        </div>
    </div>
</section>


{{-- PENGANTAR --}}
<section class="fe-section">
    <div class="fe-container">

        <div class="row align-items-center g-5">

            <div class="col-lg-6" data-aos="fade-right">

                @if (! empty($c['intro_label']))
                    <div class="fe-section-label">{{ $c['intro_label'] }}</div>
                @endif

                <h2 class="fe-section-title" style="text-align: left; font-size: 36px; margin-bottom: 24px;">
                    {!! $c['intro_title'] ?? '' !!}
                </h2>

                @foreach ($paragraphs as $p)
                    <p style="color: var(--fe-muted); line-height: 1.8; margin-bottom: 18px;">
                        {!! $p !!}
                    </p>
                @endforeach

            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="fe-stat-box">
                            <div class="fe-stat-box-icon"><i class="bi bi-people-fill"></i></div>
                            <div class="fe-stat-box-value fe-counter" data-countup="{{ $stats['pengurus'] }}">0</div>
                            <div class="fe-stat-box-label">Pengurus Aktif</div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="fe-stat-box">
                            <div class="fe-stat-box-icon"><i class="bi bi-diagram-3-fill"></i></div>
                            <div class="fe-stat-box-value fe-counter" data-countup="{{ $stats['departemen'] }}">0</div>
                            <div class="fe-stat-box-label">Departemen</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="fe-stat-box">
                            <div class="fe-stat-box-icon"><i class="bi bi-kanban-fill"></i></div>
                            <div class="fe-stat-box-value fe-counter" data-countup="{{ $stats['program_kerja'] }}">0</div>
                            <div class="fe-stat-box-label">Program Kerja</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>


{{-- NILAI-NILAI --}}
@if (count($values) > 0)
    <section class="fe-section" style="background: var(--fe-section);">
        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                @if (! empty($c['values_label']))
                    <div class="fe-section-label">{{ $c['values_label'] }}</div>
                @endif

                <h2 class="fe-section-title">
                    {!! $c['values_title'] ?? 'Nilai Kami' !!}
                </h2>
            </div>

            <div class="row g-4 justify-content-center">

                @foreach ($values as $index => $v)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="fe-card fe-tilt" style="text-align: center;">
                            <div class="fe-card-icon" style="margin: 0 auto 18px;">
                                <i class="bi {{ $v['icon'] ?? 'bi-star-fill' }}"></i>
                            </div>
                            <h3 class="fe-card-title">{{ $v['title'] ?? '' }}</h3>
                            <p class="fe-card-text">{{ $v['description'] ?? '' }}</p>
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>
@endif


{{-- ✅ BPH — BADAN PENGURUS HARIAN (section baru, SEBELUM departemen) --}}
@if (isset($bph) && $bph->count() > 0)
    <section class="fe-section">
        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                <div class="fe-section-label">Badan Pengurus Harian</div>
                <h2 class="fe-section-title">
                    Pengurus <span class="accent">Inti</span> Kami
                </h2>
                <p class="fe-section-desc">
                    Ketua, wakil, sekretaris, dan bendahara yang menggerakkan HIMAPRO TI SAKTI.
                </p>
            </div>

            <div class="row g-4 justify-content-center">

                @foreach ($bph as $index => $p)
                    <div class="col-lg-3 col-md-4 col-6" data-aos="fade-up" data-aos-delay="{{ $index * 80 }}">
                        @include('frontend.struktur._card', ['pengurus' => $p])
                    </div>
                @endforeach

            </div>

        </div>
    </section>
@endif


{{-- DEPARTEMEN (tetap 3 departemen, tidak termasuk BPH) --}}
@if ($departemens->count() > 0)
    <section class="fe-section" style="background: var(--fe-section);">
        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                <div class="fe-section-label">Departemen</div>
                <h2 class="fe-section-title">
                    Departemen <span class="accent">Kami</span>
                </h2>
                <p class="fe-section-desc">
                    Tiga departemen utama yang membangun ekosistem HIMAPRO TI SAKTI.
                </p>
            </div>

            <div class="row g-4 justify-content-center">

                @foreach ($departemens as $index => $dep)
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        <div class="fe-card" style="text-align: center;">

                            <div style="
                                width: 70px;
                                height: 70px;
                                margin: 0 auto 20px;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                border-radius: 18px;
                                background: {{ $dep->warna ?: 'var(--fe-primary)' }};
                                color: #111;
                                font-size: 30px;
                            ">
                                <i class="bi {{ $dep->icon ?: 'bi-diagram-3-fill' }}"></i>
                            </div>

                            <h3 class="fe-card-title">{{ $dep->nama }}</h3>

                            <p class="fe-card-text">
                                {{ $dep->deskripsi ?: 'Departemen HIMAPRO TI SAKTI.' }}
                            </p>

                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>
@endif


{{-- CTA --}}
<section class="fe-cta-section">
    <div class="fe-container">
        <div class="fe-cta fe-cta-dramatic" data-aos="zoom-in">

            <div class="fe-cta-orb fe-cta-orb-1"></div>
            <div class="fe-cta-orb fe-cta-orb-2"></div>

            <div class="fe-cta-content">
                <h2 class="fe-cta-title">
                    Ingin Tahu <span class="accent">Lebih Banyak</span>?
                </h2>

                <p class="fe-cta-desc">
                    Jelajahi visi misi, sejarah, atau struktur pengurus kami.
                </p>

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('frontend.about.visi-misi') }}" class="fe-btn fe-btn-primary">
                        <i class="bi bi-bullseye"></i>
                        Visi & Misi
                    </a>
                    <a href="{{ route('frontend.about.sejarah') }}" class="fe-btn fe-btn-outline">
                        <i class="bi bi-clock-history"></i>
                        Sejarah
                    </a>
                    <a href="{{ route('frontend.struktur') }}" class="fe-btn fe-btn-outline">
                        <i class="bi bi-diagram-3"></i>
                        Struktur
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection