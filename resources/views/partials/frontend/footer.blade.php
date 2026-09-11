@php
    $siteLogo = $appSettings['site_logo'] ?? null;
    $siteName = $appSettings['site_name'] ?? 'HIMAPRO TI SAKTI';

    $footerContent = $footerSection?->content ?? [];
    $footerDesc = $footerContent['description'] ?? ($appSettings['site_description'] ?? 'Himpunan Mahasiswa Program Studi Teknologi Informasi SAKTI.');
    $navLabel = $footerContent['nav_label'] ?? 'Navigasi';
    $navMenu = collect($footerContent['nav_menu'] ?? [])->where('is_active', true)->values();
    $programLabel = $footerContent['program_label'] ?? 'Program';
    $programMenu = collect($footerContent['program_menu'] ?? [])->where('is_active', true)->values();
    $contactLabel = $footerContent['contact_label'] ?? 'Kontak';
    $showSosial = $footerContent['show_sosial'] ?? true;
@endphp

<footer class="fe-footer">

    <div class="fe-container">

        <div class="row g-5">

            {{-- BRAND --}}
            <div class="col-lg-4 col-md-6">

                <a href="{{ route('home') }}" class="fe-brand mb-3">

                    @if ($siteLogo)
                        <div class="fe-brand-logo">
                            <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $siteName }}">
                        </div>
                    @else
                        <div class="fe-brand-mark">HT</div>
                    @endif

                    <div class="fe-brand-text">
                        <span class="fe-brand-name">{{ $siteName }}</span>
                    </div>
                </a>

                <p class="fe-footer-text" style="margin-top: 16px;">
                    {{ $footerDesc }}
                </p>

                @if ($showSosial)
                    <div class="fe-footer-socials">

                        @if (! empty($appSettings['social_instagram']))
                            <a href="{{ $appSettings['social_instagram'] }}" target="_blank" class="fe-footer-social" title="Instagram">
                                <i class="bi bi-instagram"></i>
                            </a>
                        @endif

                        @if (! empty($appSettings['social_tiktok']))
                            <a href="{{ $appSettings['social_tiktok'] }}" target="_blank" class="fe-footer-social" title="TikTok">
                                <i class="bi bi-tiktok"></i>
                            </a>
                        @endif

                        @if (! empty($appSettings['social_youtube']))
                            <a href="{{ $appSettings['social_youtube'] }}" target="_blank" class="fe-footer-social" title="YouTube">
                                <i class="bi bi-youtube"></i>
                            </a>
                        @endif

                        @if (! empty($appSettings['social_whatsapp']))
                            <a href="{{ $appSettings['social_whatsapp'] }}" target="_blank" class="fe-footer-social" title="WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        @endif

                        @if (! empty($appSettings['social_facebook']))
                            <a href="{{ $appSettings['social_facebook'] }}" target="_blank" class="fe-footer-social" title="Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                        @endif

                    </div>
                @endif

            </div>


            {{-- NAVIGASI --}}
            @if ($navMenu->count() > 0)
                <div class="col-lg-2 col-md-6 col-6">

                    <h3 class="fe-footer-title">{{ $navLabel }}</h3>

                    <div class="fe-footer-links">

                        @foreach ($navMenu as $item)
                            <a href="{{ $item['link'] ?? '#' }}" class="fe-footer-link">
                                <i class="bi bi-chevron-right" style="font-size: 10px;"></i>
                                {{ $item['label'] ?? '' }}
                            </a>
                        @endforeach

                    </div>

                </div>
            @endif


            {{-- PROGRAM --}}
            @if ($programMenu->count() > 0)
                <div class="col-lg-3 col-md-6 col-6">

                    <h3 class="fe-footer-title">{{ $programLabel }}</h3>

                    <div class="fe-footer-links">

                        @foreach ($programMenu as $item)
                            <a href="{{ $item['link'] ?? '#' }}" class="fe-footer-link">
                                <i class="bi bi-bookmark-fill" style="font-size: 10px;"></i>
                                {{ $item['label'] ?? '' }}
                            </a>
                        @endforeach

                    </div>

                </div>
            @endif


            {{-- KONTAK --}}
            <div class="col-lg-3 col-md-6">

                <h3 class="fe-footer-title">{{ $contactLabel }}</h3>

                <div class="fe-footer-links">

                    @if (! empty($appSettings['contact_address']))
                        <div class="fe-footer-link">
                            <i class="bi bi-geo-alt-fill"></i>
                            {{ $appSettings['contact_address'] }}
                        </div>
                    @endif

                    @if (! empty($appSettings['contact_email']))
                        <a href="mailto:{{ $appSettings['contact_email'] }}" class="fe-footer-link">
                            <i class="bi bi-envelope-fill"></i>
                            {{ $appSettings['contact_email'] }}
                        </a>
                    @endif

                    @if (! empty($appSettings['contact_phone']))
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $appSettings['contact_phone']) }}" class="fe-footer-link">
                            <i class="bi bi-telephone-fill"></i>
                            {{ $appSettings['contact_phone'] }}
                        </a>
                    @endif

                    @if (! empty($appSettings['contact_hours']))
                        <div class="fe-footer-link">
                            <i class="bi bi-clock-fill"></i>
                            {{ $appSettings['contact_hours'] }}
                        </div>
                    @endif

                </div>

            </div>

        </div>


        {{-- BOTTOM --}}
        <div class="fe-footer-bottom">

            <div>
                &copy; {{ date('Y') }}
                <strong>{{ $siteName }}</strong>.
                All rights reserved.
            </div>

            <div>
                Made with <i class="bi bi-heart-fill" style="color: #ef4444;"></i>
                by Pengurus {{ $siteName }}
            </div>

        </div>

    </div>

</footer>