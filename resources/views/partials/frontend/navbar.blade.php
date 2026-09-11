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
@endphp

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
                    <div class="fe-brand-mark">
                        HT
                    </div>
                @endif

                <div class="fe-brand-text">
                    <span class="fe-brand-name">
                        {{ $brandText }}
                    </span>

                    @if (! empty($brandTagline))
                        <span class="fe-brand-tag">
                            {{ $brandTagline }}
                        </span>
                    @endif
                </div>

            </a>


            {{-- MENU --}}
            <div class="fe-nav-menu" id="feNavMenu">

                @foreach ($menuItems as $item)
                    @php
                        $link = $item['link'] ?? '#';
                        // Cek apakah link active
                        $isActive = false;
                        if ($link === '/') {
                            $isActive = request()->routeIs('home');
                        } elseif ($link !== '#') {
                            $isActive = request()->is(ltrim($link, '/') . '*');
                        }
                    @endphp

                    <a
                        href="{{ $link }}"
                        class="fe-nav-link {{ $isActive ? 'active' : '' }}"
                    >
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


            {{-- MOBILE TOGGLE --}}
            <button class="fe-nav-toggle" type="button" aria-label="Menu">
                <i class="bi bi-list"></i>
            </button>

        </div>

    </div>

</nav>

<div class="fe-nav-overlay" id="feNavOverlay"></div>