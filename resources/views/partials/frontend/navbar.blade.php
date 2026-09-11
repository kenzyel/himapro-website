@php
    $siteLogo = $appSettings['site_logo'] ?? null;
    $siteName = $appSettings['site_name'] ?? 'HIMAPRO TI SAKTI';
@endphp

<nav class="fe-navbar" id="feNavbar">

    <div class="fe-container">

        <div class="fe-navbar-inner">

            {{-- BRAND --}}
            <a href="{{ route('home') }}" class="fe-brand">

                @if ($siteLogo)
                    <div class="fe-brand-logo">
                        <img
                            src="{{ asset('storage/' . $siteLogo) }}"
                            alt="{{ $siteName }}"
                        >
                    </div>
                @else
                    <div class="fe-brand-mark">
                        HT
                    </div>
                @endif

                <div class="fe-brand-text">
                    <span class="fe-brand-name">
                        {{ $siteName }}
                    </span>
                </div>

            </a>


            {{-- MENU --}}
            <div class="fe-nav-menu" id="feNavMenu">

                <a
                    href="{{ route('home') }}"
                    class="fe-nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                >
                    Beranda
                </a>

                <a
                    href="{{ Route::has('frontend.about') ? route('frontend.about') : '#' }}"
                    class="fe-nav-link {{ request()->routeIs('frontend.about*') ? 'active' : '' }}"
                >
                    Tentang
                </a>

                <a
                    href="{{ Route::has('frontend.struktur') ? route('frontend.struktur') : '#' }}"
                    class="fe-nav-link {{ request()->routeIs('frontend.struktur*') ? 'active' : '' }}"
                >
                    Struktur
                </a>

                <a
                    href="{{ Route::has('frontend.gallery') ? route('frontend.gallery') : '#' }}"
                    class="fe-nav-link {{ request()->routeIs('frontend.gallery*') ? 'active' : '' }}"
                >
                    Gallery
                </a>

                <a
                    href="{{ Route::has('frontend.contact') ? route('frontend.contact') : '#' }}"
                    class="fe-nav-link {{ request()->routeIs('frontend.contact*') ? 'active' : '' }}"
                >
                    Kontak
                </a>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="fe-nav-cta">
                        <i class="bi bi-grid-1x2-fill"></i>
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('admin.login') }}" class="fe-nav-cta">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Login Admin
                    </a>
                @endauth

            </div>


            {{-- MOBILE TOGGLE --}}
            <button class="fe-nav-toggle" type="button" aria-label="Menu">
                <i class="bi bi-list"></i>
            </button>

        </div>

    </div>

</nav>

<div class="fe-nav-overlay" id="feNavOverlay"></div>