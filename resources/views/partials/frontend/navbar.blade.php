@php
    $siteLogo = $appSettings['site_logo'] ?? null;
    $siteName = $appSettings['site_name'] ?? 'HIMAPRO TI SAKTI';

    $navContent = $navbarSection?->content ?? [];
    $brandText = $navContent['brand_text'] ?? $siteName;
    $brandTagline = $navContent['brand_tagline'] ?? '';
    $menuItems = collect($navContent['menu'] ?? [])->where('is_active', true)->values();
    $ctaShow = $navContent['cta_show'] ?? true;
    $ctaText = $navContent['cta_text'] ?? 'Login Admin';
    $ctaLink = $navContent['cta_link'] ?? '/admin/login';
    $ctaIcon = $navContent['cta_icon'] ?? 'bi-box-arrow-in-right';

    // Helper untuk cek active link
    $isActiveLink = function ($link) {
        if ($link === '/') return request()->routeIs('home');
        if ($link === '#') return false;
        return request()->is(ltrim($link, '/') . '*');
    };
@endphp

{{-- =========================================================
     DESKTOP NAVBAR — Hanya tampil di desktop (>= 992px)
     ========================================================= --}}
<nav class="fe-navbar" id="feNavbar">
    <div class="fe-container">
        <div class="fe-navbar-inner">

            {{-- BRAND --}}
            <a href="{{ route('home') }}" class="fe-brand">
                @if ($siteLogo)
                    <div class="fe-brand-logo">
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $brandText }}">
                    </div>
                @else
                    <div class="fe-brand-mark">HT</div>
                @endif

                <div class="fe-brand-text">
                    <span class="fe-brand-name">{{ $brandText }}</span>
                    @if (! empty($brandTagline))
                        <span class="fe-brand-tag">{{ $brandTagline }}</span>
                    @endif
                </div>
            </a>

            {{-- MENU DESKTOP --}}
            <div class="fe-nav-menu">
                @foreach ($menuItems as $item)
                    @php
                        $link = $item['link'] ?? '#';
                        $isActive = $isActiveLink($link);
                    @endphp
                    <a href="{{ $link }}" class="fe-nav-link {{ $isActive ? 'active' : '' }}">
                        @if (! empty($item['icon']))
                            <i class="bi {{ $item['icon'] }}" style="margin-right: 6px;"></i>
                        @endif
                        {{ $item['label'] ?? '' }}
                    </a>
                @endforeach

                @if ($ctaShow)
                    <a href="{{ $ctaLink }}" class="fe-nav-cta">
                        @if (! empty($ctaIcon))
                            <i class="bi {{ $ctaIcon }}"></i>
                        @endif
                        {{ $ctaText }}
                    </a>
                @endif
            </div>

        </div>
    </div>
</nav>


{{-- =========================================================
     MOBILE TOPBAR — Hanya tampil di mobile (< 992px)
     Berisi brand + tombol hamburger
     ========================================================= --}}
<header class="fe-mobile-topbar" id="feMobileTopbar">
    <div class="fe-container">
        <div class="fe-mobile-topbar-inner">

            {{-- BRAND --}}
            <a href="{{ route('home') }}" class="fe-brand">
                @if ($siteLogo)
                    <div class="fe-brand-logo">
                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $brandText }}">
                    </div>
                @else
                    <div class="fe-brand-mark">HT</div>
                @endif

                <div class="fe-brand-text">
                    <span class="fe-brand-name">{{ $brandText }}</span>
                    @if (! empty($brandTagline))
                        <span class="fe-brand-tag">{{ $brandTagline }}</span>
                    @endif
                </div>
            </a>

            {{-- HAMBURGER --}}
            <button
                class="fe-mobile-toggle"
                type="button"
                id="feMobileToggle"
                aria-label="Buka Menu"
                aria-expanded="false"
                aria-controls="feMobileSidebar"
            >
                <i class="bi bi-list"></i>
            </button>

        </div>
    </div>
</header>


{{-- =========================================================
     MOBILE SIDEBAR DRAWER — Hanya tampil di mobile
     ========================================================= --}}
<aside
    class="fe-mobile-sidebar"
    id="feMobileSidebar"
    aria-hidden="true"
    role="dialog"
    aria-modal="true"
    aria-label="Menu Navigasi"
>

    {{-- HEADER SIDEBAR --}}
    <div class="fe-mobile-sidebar-header">
        <span class="fe-mobile-sidebar-title">Menu</span>
        <button
            class="fe-mobile-sidebar-close"
            type="button"
            id="feMobileClose"
            aria-label="Tutup Menu"
        >
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- MENU LIST --}}
    <nav class="fe-mobile-sidebar-nav">
        @foreach ($menuItems as $item)
            @php
                $link = $item['link'] ?? '#';
                $isActive = $isActiveLink($link);
            @endphp
            <a href="{{ $link }}" class="fe-mobile-nav-link {{ $isActive ? 'active' : '' }}">
                @if (! empty($item['icon']))
                    <i class="bi {{ $item['icon'] }}"></i>
                @else
                    <i class="bi bi-circle"></i>
                @endif
                <span>{{ $item['label'] ?? '' }}</span>
            </a>
        @endforeach
    </nav>

    {{-- FOOTER SIDEBAR — CTA --}}
    @if ($ctaShow)
        <div class="fe-mobile-sidebar-footer">
            <a href="{{ $ctaLink }}" class="fe-mobile-cta">
                @if (! empty($ctaIcon))
                    <i class="bi {{ $ctaIcon }}"></i>
                @endif
                {{ $ctaText }}
            </a>
        </div>
    @endif

</aside>

{{-- OVERLAY (untuk tutup sidebar saat klik luar) --}}
<div class="fe-mobile-overlay" id="feMobileOverlay"></div>