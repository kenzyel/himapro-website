@extends('layouts.app')

@section('title', 'Struktur Pengurus')

@section('content')

{{-- PAGE HEADER --}}
<section class="fe-page-header">
    <div class="fe-container">
        <div class="fe-page-header-content" data-aos="fade-up">
            <nav class="fe-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <span>Struktur</span>
            </nav>

            <div class="fe-section-label">Struktur Organisasi</div>

            <h1 class="fe-page-title">
                Pengurus <span class="accent">HIMAPRO TI SAKTI</span>
            </h1>

            <p class="fe-page-desc">
                Periode 2026/2027 — orang-orang di balik setiap program dan kegiatan.
            </p>
        </div>
    </div>
</section>


{{-- PEMBINA --}}
@if ($pembina->count() > 0)
    <section class="fe-section-sm">
        <div class="fe-container">

            <div class="fe-struktur-heading" data-aos="fade-up">
                <div class="fe-section-label">Pembina</div>
                <h2 class="fe-section-title" style="font-size: 28px;">
                    Pembina <span class="accent">Organisasi</span>
                </h2>
            </div>

            <div class="fe-pengurus-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); max-width: 720px; margin: 0 auto; justify-content: center;">
                @foreach ($pembina as $p)
                    <div data-aos="fade-up">
                        @include('frontend.struktur._card', ['pengurus' => $p, 'featured' => true])
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endif


{{-- PIMPINAN --}}
@if ($pimpinan->count() > 0)
    <section class="fe-section-sm" style="background: var(--fe-section);">
        <div class="fe-container">

            <div class="fe-struktur-heading" data-aos="fade-up">
                <div class="fe-section-label">Badan Pengurus Harian</div>
                <h2 class="fe-section-title" style="font-size: 28px;">
                    Ketua & <span class="accent">Wakil</span>
                </h2>
            </div>

            <div class="fe-pengurus-grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); max-width: 780px; margin: 0 auto;">
                @foreach ($pimpinan as $index => $p)
                    <div data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                        @include('frontend.struktur._card', ['pengurus' => $p, 'featured' => true])
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endif


{{-- SEKRETARIS & BENDAHARA --}}
@if ($sekretaris->count() > 0 || $bendahara->count() > 0)
    <section class="fe-section-sm">
        <div class="fe-container">

            <div class="row g-5">

                @if ($sekretaris->count() > 0)
                    <div class="col-lg-6">
                        <div class="fe-struktur-heading" style="text-align: left; margin-bottom: 30px;" data-aos="fade-up">
                            <!-- <div class="fe-section-label">Sekretaris</div> -->
                            <h2 class="fe-section-title" style="font-size: 24px; text-align: left;">
                                Sekretaris <span class="accent">Umum</span>
                            </h2>
                        </div>

                        <div class="fe-pengurus-grid" style="grid-template-columns: repeat(2, 1fr);">
                            @foreach ($sekretaris as $p)
                                <div data-aos="fade-up">
                                    @include('frontend.struktur._card', ['pengurus' => $p])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($bendahara->count() > 0)
                    <div class="col-lg-6">
                        <div class="fe-struktur-heading" style="text-align: left; margin-bottom: 30px;" data-aos="fade-up">
                            <!-- <div class="fe-section-label">Bendahara</div> -->
                            <h2 class="fe-section-title" style="font-size: 24px; text-align: left;">
                                Bendahara <span class="accent">Umum</span>
                            </h2>
                        </div>

                        <div class="fe-pengurus-grid" style="grid-template-columns: repeat(2, 1fr);">
                            @foreach ($bendahara as $p)
                                <div data-aos="fade-up">
                                    @include('frontend.struktur._card', ['pengurus' => $p])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </section>
@endif


{{-- DEPARTEMEN (CO + AGT) --}}
@if ($co->count() > 0 || $agt->count() > 0)
    <section class="fe-section" style="background: var(--fe-section);">
        <div class="fe-container">

            <div class="fe-struktur-heading" data-aos="fade-up">
                <div class="fe-section-label">Departemen</div>
                <h2 class="fe-section-title">
                    Kepala Departemen & <span class="accent">Anggota</span>
                </h2>
            </div>

            @php
                $coByDept = $co->groupBy('departemen_id');
                $agtByDept = $agt->groupBy('departemen_id');
                $deptIds = $coByDept->keys()->merge($agtByDept->keys())->unique();
            @endphp

            @foreach ($deptIds as $deptId)
                @php
                    $coList = $coByDept->get($deptId, collect());
                    $agtList = $agtByDept->get($deptId, collect());
                    $departemen = $coList->first()?->departemen ?? $agtList->first()?->departemen;
                @endphp

                <div class="fe-dept-block" data-aos="fade-up">

                    <div class="fe-dept-header">
                        @if ($departemen)
                            <div class="fe-dept-icon" style="background: {{ $departemen->warna ?: 'var(--fe-primary)' }};">
                                <i class="bi {{ $departemen->icon ?: 'bi-diagram-3-fill' }}"></i>
                            </div>
                            <div>
                                <h3 class="fe-dept-name">Departemen {{ $departemen->nama }}</h3>
                                <div class="fe-dept-sub">{{ $coList->count() + $agtList->count() }} anggota</div>
                            </div>
                        @else
                            <h3 class="fe-dept-name">Departemen</h3>
                        @endif
                    </div>

                    <div class="fe-pengurus-grid">
                        @foreach ($coList as $p)
                            <div>
                                @include('frontend.struktur._card', ['pengurus' => $p])
                            </div>
                        @endforeach

                        @foreach ($agtList as $p)
                            <div>
                                @include('frontend.struktur._card', ['pengurus' => $p])
                            </div>
                        @endforeach
                    </div>

                </div>
            @endforeach

        </div>
    </section>
@endif

@endsection


@push('styles')
<style>
/* PAGE HEADER */

.fe-page-header {
    padding: 160px 0 80px;
    position: relative;
    overflow: hidden;
    background:
        radial-gradient(ellipse at top right, rgba(255, 210, 26, 0.06), transparent 50%),
        radial-gradient(ellipse at bottom left, rgba(245, 169, 0, 0.04), transparent 50%);
}

.fe-page-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--fe-border), transparent);
}

.fe-page-header-content {
    max-width: 720px;
}

.fe-breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12.5px;
    color: var(--fe-muted);
    margin-bottom: 22px;
}

.fe-breadcrumb a {
    color: var(--fe-muted);
    transition: color var(--fe-transition);
}

.fe-breadcrumb a:hover {
    color: var(--fe-primary);
}

.fe-breadcrumb span:last-child {
    color: var(--fe-text);
    font-weight: 700;
}

.fe-page-title {
    font-size: 48px;
    font-weight: 700;
    letter-spacing: -0.03em;
    line-height: 1.1;
    margin: 16px 0 18px;
    font-family: var(--font-display);
}

.fe-page-title .accent {
    background: var(--fe-grad-primary);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-block;
}

.fe-page-desc {
    font-size: 16px;
    color: var(--fe-muted);
    line-height: 1.7;
    margin: 0;
}

@media (max-width: 767.98px) {
    .fe-page-header { padding: 130px 0 50px; }
    .fe-page-title { font-size: 32px; }
    .fe-page-desc { font-size: 14.5px; }
}

/* DEPT BLOCK */

.fe-dept-block {
    margin-bottom: 60px;
    padding-bottom: 50px;
    border-bottom: 1px solid var(--fe-border);
}

.fe-dept-block:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: 0;
}

.fe-dept-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 30px;
}

.fe-dept-icon {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 16px;
    color: #111;
    font-size: 24px;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
}

.fe-dept-name {
    font-size: 22px;
    font-weight: 700;
    margin: 0 0 4px;
    letter-spacing: -0.01em;
    font-family: var(--font-display);
}

.fe-dept-sub {
    font-size: 12px;
    color: var(--fe-muted);
}
</style>
@endpush