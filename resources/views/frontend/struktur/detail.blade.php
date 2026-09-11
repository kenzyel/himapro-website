@extends('layouts.app')

@section('title', $pengurus->nama)

@section('content')

{{-- PAGE HEADER --}}
<section class="fe-page-header">
    <div class="fe-container">
        <div class="fe-page-header-content" data-aos="fade-up">
            <nav class="fe-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <a href="{{ route('frontend.struktur') }}">Struktur</a>
                <span>/</span>
                <span>{{ $pengurus->nama }}</span>
            </nav>
        </div>
    </div>
</section>


{{-- PROFIL --}}
<section class="fe-section" style="padding-top: 20px;">
    <div class="fe-container">

        <div class="row g-5">

            {{-- FOTO & INFO SINGKAT --}}
            <div class="col-lg-4" data-aos="fade-right">

                <div class="fe-profile-card">

                    <div class="fe-profile-photo">
                        @if ($pengurus->foto)
                            <img src="{{ asset('storage/' . $pengurus->foto) }}" alt="{{ $pengurus->nama }}">
                        @else
                            <div class="fe-profile-initials">
                                {{ strtoupper(substr($pengurus->nama, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <h1 class="fe-profile-name">{{ $pengurus->nama }}</h1>
                    <div class="fe-profile-role">{{ $pengurus->jabatan }}</div>

                    @if ($pengurus->departemen)
                        <div class="fe-profile-dept">
                            <i class="bi {{ $pengurus->departemen->icon ?: 'bi-diagram-3-fill' }}"></i>
                            Departemen {{ $pengurus->departemen->nama }}
                        </div>
                    @endif

                    <div class="fe-profile-meta">
                        <div class="fe-profile-meta-item">
                            <i class="bi bi-calendar3"></i>
                            <span>{{ $pengurus->periode }}</span>
                        </div>

                        @if ($pengurus->email)
                            <div class="fe-profile-meta-item">
                                <i class="bi bi-envelope-fill"></i>
                                <a href="mailto:{{ $pengurus->email }}">{{ $pengurus->email }}</a>
                            </div>
                        @endif

                        @if ($pengurus->telepon)
                            <div class="fe-profile-meta-item">
                                <i class="bi bi-telephone-fill"></i>
                                <a href="tel:{{ $pengurus->telepon }}">{{ $pengurus->telepon }}</a>
                            </div>
                        @endif
                    </div>

                </div>

            </div>


            {{-- DETAIL --}}
            <div class="col-lg-8" data-aos="fade-left">

                @if ($pengurus->bio)
                    <div class="fe-profile-section">
                        <div class="fe-section-label">Tentang</div>
                        <h2 class="fe-profile-section-title">Bio Singkat</h2>
                        <p class="fe-profile-text">{{ $pengurus->bio }}</p>
                    </div>
                @endif

                <div class="fe-profile-section">
                    <div class="fe-section-label">Informasi</div>
                    <h2 class="fe-profile-section-title">Detail Jabatan</h2>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="fe-info-box">
                                <div class="fe-info-label">Jabatan</div>
                                <div class="fe-info-value">{{ $pengurus->jabatan }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="fe-info-box">
                                <div class="fe-info-label">Tipe Jabatan</div>
                                <div class="fe-info-value">
                                    {{ ucfirst(str_replace('_', ' ', $pengurus->tipe_jabatan)) }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="fe-info-box">
                                <div class="fe-info-label">Departemen</div>
                                <div class="fe-info-value">
                                    {{ $pengurus->departemen?->nama ?? 'Pimpinan' }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="fe-info-box">
                                <div class="fe-info-label">Atasan</div>
                                <div class="fe-info-value">
                                    {{ $pengurus->parent?->nama ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($pengurus->children->count() > 0)
                    <div class="fe-profile-section">
                        <div class="fe-section-label">Tim</div>
                        <h2 class="fe-profile-section-title">Anggota di Bawahnya</h2>

                        <div class="row g-3">
                            @foreach ($pengurus->children as $child)
                                <div class="col-md-6">
                                    <a href="{{ route('frontend.struktur.detail', $child) }}" class="fe-mini-card">
                                        <div class="fe-mini-avatar">
                                            {{ strtoupper(substr($child->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fe-mini-name">{{ $child->nama }}</div>
                                            <div class="fe-mini-role">{{ $child->jabatan }}</div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>

        </div>

        {{-- BACK --}}
        <div style="margin-top: 50px;" data-aos="fade-up">
            <a href="{{ route('frontend.struktur') }}" class="fe-btn fe-btn-outline">
                <i class="bi bi-arrow-left"></i>
                Kembali ke Struktur
            </a>
        </div>

    </div>
</section>

@endsection


@push('styles')
<style>
/* PAGE HEADER */

.fe-page-header {
    padding: 160px 0 40px;
    position: relative;
    overflow: hidden;
    background:
        radial-gradient(ellipse at top right, rgba(255, 210, 26, 0.06), transparent 50%);
}

.fe-breadcrumb {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 12.5px;
    color: var(--fe-muted);
    margin-bottom: 0;
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

@media (max-width: 767.98px) {
    .fe-page-header { padding: 130px 0 30px; }
}

/* PROFILE CARD */

.fe-profile-card {
    position: sticky;
    top: 100px;
    padding: 0;
    border-radius: var(--fe-radius-xl);
    background: linear-gradient(145deg, var(--fe-card), var(--fe-section));
    border: 1px solid var(--fe-border);
    text-align: center;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
}

.fe-profile-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 30%;
    right: 30%;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--fe-primary), transparent);
    z-index: 2;
}

.fe-profile-name {
    font-size: 22px;
    font-weight: 800;
    letter-spacing: -0.02em;
    margin: 24px 24px 6px;
    line-height: 1.2;
    font-family: var(--font-display);
}

.fe-profile-role {
    font-size: 14px;
    color: var(--fe-primary);
    font-weight: 800;
    margin: 0 24px 16px;
    letter-spacing: 0.02em;
}

.fe-profile-dept {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 999px;
    background: rgba(255, 210, 26, 0.08);
    border: 1px solid rgba(255, 210, 26, 0.2);
    color: var(--fe-primary);
    font-size: 12px;
    font-weight: 700;
    margin: 0 24px 22px;
}

.fe-profile-meta {
    padding: 22px 24px;
    border-top: 1px solid var(--fe-border);
    display: flex;
    flex-direction: column;
    gap: 12px;
    text-align: left;
}

.fe-profile-meta-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13px;
    color: var(--fe-muted);
}

.fe-profile-meta-item i {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 9px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--fe-border);
    color: var(--fe-primary);
    font-size: 13px;
    flex-shrink: 0;
}

.fe-profile-meta-item a {
    color: var(--fe-muted);
}

.fe-profile-meta-item a:hover {
    color: var(--fe-primary);
}

/* SECTIONS */

.fe-profile-section {
    margin-bottom: 40px;
    padding-bottom: 40px;
    border-bottom: 1px solid var(--fe-border);
}

.fe-profile-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: 0;
}

.fe-profile-section-title {
    font-size: 26px;
    font-weight: 700;
    letter-spacing: -0.02em;
    margin: 12px 0 18px;
    font-family: var(--font-display);
}

.fe-profile-text {
    font-size: 15px;
    color: var(--fe-muted);
    line-height: 1.9;
    margin: 0;
}

.fe-info-box {
    padding: 18px;
    border-radius: var(--fe-radius);
    background: var(--fe-card);
    border: 1px solid var(--fe-border);
    height: 100%;
}

.fe-info-label {
    font-size: 10.5px;
    color: var(--fe-muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 800;
    margin-bottom: 6px;
}

.fe-info-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--fe-text);
}

/* MINI CARD */

.fe-mini-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 16px;
    border-radius: var(--fe-radius);
    background: var(--fe-card);
    border: 1px solid var(--fe-border);
    transition: all var(--fe-transition);
    text-decoration: none;
    color: inherit;
}

.fe-mini-card:hover {
    border-color: rgba(255, 210, 26, 0.35);
    transform: translateX(4px);
}

.fe-mini-avatar {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--fe-primary), var(--fe-secondary));
    color: #111;
    font-weight: 900;
    font-size: 17px;
    flex-shrink: 0;
    font-family: var(--font-display);
}

.fe-mini-name {
    font-size: 13.5px;
    font-weight: 700;
    margin-bottom: 2px;
}

.fe-mini-role {
    font-size: 11.5px;
    color: var(--fe-muted);
}

@media (max-width: 991.98px) {
    .fe-profile-card {
        position: static;
    }
}
</style>
@endpush