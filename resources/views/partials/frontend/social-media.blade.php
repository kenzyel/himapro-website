{{-- =========================================================
     SOCIAL MEDIA SECTION — Icon Neon + Particles Plexus
     ========================================================= --}}
@php
    $socials = [
        ['key' => 'social_instagram', 'icon' => 'bi-instagram', 'label' => 'Instagram', 'class' => 'ig', 'url' => $appSettings['social_instagram'] ?? null],
        ['key' => 'social_tiktok', 'icon' => 'bi-tiktok', 'label' => 'TikTok', 'class' => 'tt', 'url' => $appSettings['social_tiktok'] ?? null],
        ['key' => 'social_youtube', 'icon' => 'bi-youtube', 'label' => 'YouTube', 'class' => 'yt', 'url' => $appSettings['social_youtube'] ?? null],
        ['key' => 'social_whatsapp', 'icon' => 'bi-whatsapp', 'label' => 'WhatsApp', 'class' => 'wa', 'url' => $appSettings['social_whatsapp'] ?? null],
        ['key' => 'social_facebook', 'icon' => 'bi-facebook', 'label' => 'Facebook', 'class' => 'fb', 'url' => $appSettings['social_facebook'] ?? null],
    ];

    // Filter hanya yang punya URL
    $socials = collect($socials)->filter(fn ($s) => ! empty($s['url']))->values();
@endphp

@if ($socials->count() > 0)
    <section class="fe-social-section">
        {{-- Canvas Particles Plexus --}}
        <canvas id="feSocialParticles" class="fe-social-particles"></canvas>

        <div class="fe-container" style="position: relative; z-index: 2;">

            <div class="fe-section-heading" data-aos="fade-up">
                <div class="fe-section-label">
                    <i class="bi bi-share-fill"></i>
                    Media Sosial
                </div>
                <h2 class="fe-section-title">
                    Ikuti <span class="accent">Kami</span>
                </h2>
                <p class="fe-section-desc">
                    Dapatkan update terbaru seputar kegiatan dan program HIMAPRO TI SAKTI.
                </p>
            </div>

            <div class="fe-social-icons" data-aos="fade-up" data-aos-delay="100">
                @foreach ($socials as $social)
                    <a
                        href="{{ $social['url'] }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="fe-social-icon {{ $social['class'] }}"
                        aria-label="{{ $social['label'] }}"
                        title="{{ $social['label'] }}"
                    >
                        <i class="bi {{ $social['icon'] }}"></i>
                    </a>
                @endforeach
            </div>

        </div>
    </section>
@endif