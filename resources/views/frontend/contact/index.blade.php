@extends('layouts.app')

@section('title', 'Kontak')

@php
    $c = $section->content ?? [];
    $mapsEmbed = $appSettings['contact_maps_embed'] ?? null;
@endphp

@section('content')

{{-- PAGE HEADER --}}
<section class="fe-page-header">
    <div class="fe-container">
        <div class="fe-page-header-content" data-aos="fade-up">
            <nav class="fe-breadcrumb">
                <a href="{{ route('home') }}">Beranda</a>
                <span>/</span>
                <span>Kontak</span>
            </nav>

            <div class="fe-section-label">Hubungi Kami</div>

            <h1 class="fe-page-title">
                {!! $c['title'] ?? 'Mari Terhubung' !!}
            </h1>

            @if (! empty($c['description']))
                <p class="fe-page-desc">{{ $c['description'] }}</p>
            @endif
        </div>
    </div>
</section>


{{-- SUCCESS MESSAGE --}}
@if (session('contact_success'))
    <div class="fe-container" style="padding-top: 30px;">
        <div class="fe-alert-success" data-aos="fade-down">
            <i class="bi bi-check-circle-fill"></i>
            <div>{{ session('contact_success') }}</div>
        </div>
    </div>
@endif


{{-- CONTACT SECTION --}}
<section class="fe-section" style="padding-top: 40px;">
    <div class="fe-container">

        <div class="row g-5">

            {{-- INFO KONTAK --}}
            <div class="col-lg-5" data-aos="fade-right">

                <div class="fe-section-label">Info Kontak</div>

                <h2 class="fe-section-title" style="text-align: left; font-size: 32px; margin-bottom: 30px;">
                    Cara <span class="accent">Menghubungi</span> Kami
                </h2>

                <div class="fe-contact-list">

                    @if (! empty($appSettings['contact_address']))
                        <div class="fe-contact-item">
                            <div class="fe-contact-icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>
                            <div>
                                <div class="fe-contact-label">Alamat</div>
                                <div class="fe-contact-value">{!! nl2br(e($appSettings['contact_address'])) !!}</div>
                            </div>
                        </div>
                    @endif

                    @if (! empty($appSettings['contact_email']))
                        <div class="fe-contact-item">
                            <div class="fe-contact-icon">
                                <i class="bi bi-envelope-fill"></i>
                            </div>
                            <div>
                                <div class="fe-contact-label">Email</div>
                                <a href="mailto:{{ $appSettings['contact_email'] }}" class="fe-contact-value">
                                    {{ $appSettings['contact_email'] }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (! empty($appSettings['contact_phone']))
                        <div class="fe-contact-item">
                            <div class="fe-contact-icon">
                                <i class="bi bi-telephone-fill"></i>
                            </div>
                            <div>
                                <div class="fe-contact-label">Telepon</div>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $appSettings['contact_phone']) }}" class="fe-contact-value">
                                    {{ $appSettings['contact_phone'] }}
                                </a>
                            </div>
                        </div>
                    @endif

                    @if (! empty($appSettings['contact_hours']))
                        <div class="fe-contact-item">
                            <div class="fe-contact-icon">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <div>
                                <div class="fe-contact-label">Jam Operasional</div>
                                <div class="fe-contact-value">{{ $appSettings['contact_hours'] }}</div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- SOSIAL --}}
                @if (
                    ! empty($appSettings['social_instagram']) ||
                    ! empty($appSettings['social_tiktok']) ||
                    ! empty($appSettings['social_youtube']) ||
                    ! empty($appSettings['social_whatsapp'])
                )
                    <div style="margin-top: 40px;">
                        <div class="fe-contact-label" style="margin-bottom: 14px;">Ikuti Kami</div>

                        <div class="fe-socials">
                            @if (! empty($appSettings['social_instagram']))
                                <a href="{{ $appSettings['social_instagram'] }}" target="_blank" class="fe-social-item" title="Instagram">
                                    <i class="bi bi-instagram"></i>
                                </a>
                            @endif

                            @if (! empty($appSettings['social_tiktok']))
                                <a href="{{ $appSettings['social_tiktok'] }}" target="_blank" class="fe-social-item" title="TikTok">
                                    <i class="bi bi-tiktok"></i>
                                </a>
                            @endif

                            @if (! empty($appSettings['social_youtube']))
                                <a href="{{ $appSettings['social_youtube'] }}" target="_blank" class="fe-social-item" title="YouTube">
                                    <i class="bi bi-youtube"></i>
                                </a>
                            @endif

                            @if (! empty($appSettings['social_whatsapp']))
                                <a href="{{ $appSettings['social_whatsapp'] }}" target="_blank" class="fe-social-item" title="WhatsApp">
                                    <i class="bi bi-whatsapp"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                @endif

            </div>


            {{-- FORM --}}
            <div class="col-lg-7" data-aos="fade-left">

                <div class="fe-contact-form-card">

                    <h2 class="fe-form-title">{{ $c['form_title'] ?? 'Kirim Pesan' }}</h2>
                    <p class="fe-form-desc">
                        {{ $c['form_description'] ?? 'Isi form di bawah ini dan kami akan segera merespons.' }}
                    </p>

                    @if ($errors->any())
                        <div class="fe-alert-error">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div>
                                <strong>Terdapat kesalahan:</strong>
                                <ul style="margin: 6px 0 0 18px; padding: 0;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('frontend.contact.store') }}" method="POST">
                        @csrf

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="nama" class="fe-form-label">
                                    Nama <span class="fe-required">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="nama"
                                    name="nama"
                                    class="fe-form-input @error('nama') error @enderror"
                                    value="{{ old('nama') }}"
                                    placeholder="Nama lengkap Anda"
                                    required
                                >
                                @error('nama')
                                    <div class="fe-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="fe-form-label">
                                    Email <span class="fe-required">*</span>
                                </label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="fe-form-input @error('email') error @enderror"
                                    value="{{ old('email') }}"
                                    placeholder="nama@email.com"
                                    required
                                >
                                @error('email')
                                    <div class="fe-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="telepon" class="fe-form-label">
                                    Telepon (opsional)
                                </label>
                                <input
                                    type="text"
                                    id="telepon"
                                    name="telepon"
                                    class="fe-form-input @error('telepon') error @enderror"
                                    value="{{ old('telepon') }}"
                                    placeholder="08xxxxxxxxxx"
                                >
                                @error('telepon')
                                    <div class="fe-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="subjek" class="fe-form-label">
                                    Subjek <span class="fe-required">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="subjek"
                                    name="subjek"
                                    class="fe-form-input @error('subjek') error @enderror"
                                    value="{{ old('subjek') }}"
                                    placeholder="Contoh: Kerja Sama Kegiatan"
                                    required
                                >
                                @error('subjek')
                                    <div class="fe-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="pesan" class="fe-form-label">
                                    Pesan <span class="fe-required">*</span>
                                </label>
                                <textarea
                                    id="pesan"
                                    name="pesan"
                                    rows="6"
                                    class="fe-form-input @error('pesan') error @enderror"
                                    placeholder="Tuliskan pesan Anda di sini..."
                                    required
                                >{{ old('pesan') }}</textarea>
                                @error('pesan')
                                    <div class="fe-form-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12" style="margin-top: 10px;">
                                <button type="submit" class="fe-btn fe-btn-primary fe-btn-lg" style="width: 100%;">
                                    <i class="bi bi-send-fill"></i>
                                    Kirim Pesan
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
</section>


{{-- GOOGLE MAPS --}}
@if (! empty($mapsEmbed))
    <section class="fe-section-sm" style="padding-top: 0;">
        <div class="fe-container">

            <div class="fe-section-heading" data-aos="fade-up">
                <div class="fe-section-label">Lokasi</div>
                <h2 class="fe-section-title">
                    Temukan <span class="accent">Kami</span>
                </h2>
            </div>

            <div class="fe-map-wrapper" data-aos="zoom-in">
                {!! $mapsEmbed !!}
            </div>

        </div>
    </section>
@endif

@endsection


@push('styles')
<style>
/* ALERT */
.fe-alert-success,
.fe-alert-error {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px 20px;
    border-radius: var(--fe-radius);
    font-size: 14px;
}

.fe-alert-success {
    background: rgba(34, 197, 94, 0.08);
    border: 1px solid rgba(34, 197, 94, 0.25);
    color: #86efac;
}

.fe-alert-error {
    background: rgba(239, 68, 68, 0.08);
    border: 1px solid rgba(239, 68, 68, 0.25);
    color: #fca5a5;
    margin-bottom: 24px;
}

.fe-alert-success i,
.fe-alert-error i {
    font-size: 18px;
    flex-shrink: 0;
}

/* CONTACT LIST */
.fe-contact-list {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.fe-contact-item {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    padding: 18px;
    border-radius: var(--fe-radius);
    background: var(--fe-card);
    border: 1px solid var(--fe-border);
    transition: all var(--fe-transition);
}

.fe-contact-item:hover {
    border-color: rgba(255, 210, 26, 0.3);
    transform: translateX(4px);
}

.fe-contact-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: rgba(255, 210, 26, 0.1);
    border: 1px solid rgba(255, 210, 26, 0.2);
    color: var(--fe-primary);
    font-size: 20px;
    flex-shrink: 0;
}

.fe-contact-label {
    font-size: 11px;
    color: var(--fe-muted);
    text-transform: uppercase;
    letter-spacing: 0.08em;
    font-weight: 800;
    margin-bottom: 6px;
}

.fe-contact-value {
    font-size: 14px;
    color: var(--fe-text);
    font-weight: 600;
    line-height: 1.5;
    text-decoration: none;
    display: block;
}

a.fe-contact-value:hover {
    color: var(--fe-primary);
}

/* SOCIALS */
.fe-socials {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.fe-social-item {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    background: var(--fe-card);
    border: 1px solid var(--fe-border);
    color: var(--fe-muted);
    font-size: 18px;
    transition: all var(--fe-transition);
}

.fe-social-item:hover {
    background: var(--fe-primary);
    border-color: var(--fe-primary);
    color: #111;
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(255, 210, 26, 0.35);
}

/* FORM */
.fe-contact-form-card {
    padding: 40px;
    border-radius: var(--fe-radius-xl);
    background: linear-gradient(145deg, var(--fe-card), var(--fe-section));
    border: 1px solid var(--fe-border);
    position: relative;
    overflow: hidden;
}

.fe-contact-form-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 25%;
    right: 25%;
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--fe-primary), transparent);
}

.fe-form-title {
    font-size: 24px;
    font-weight: 700;
    letter-spacing: -0.02em;
    margin: 0 0 8px;
    font-family: var(--font-display);
}

.fe-form-desc {
    font-size: 13.5px;
    color: var(--fe-muted);
    margin-bottom: 28px;
}

.fe-form-label {
    display: block;
    font-size: 12.5px;
    font-weight: 700;
    color: var(--fe-text);
    margin-bottom: 8px;
}

.fe-required {
    color: var(--fe-primary);
}

.fe-form-input {
    width: 100%;
    padding: 13px 16px;
    border-radius: 11px;
    background: rgba(11, 11, 13, 0.6);
    border: 1px solid var(--fe-border);
    color: var(--fe-text);
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: all var(--fe-transition);
    resize: vertical;
}

.fe-form-input::placeholder {
    color: var(--fe-muted);
}

.fe-form-input:focus {
    border-color: var(--fe-primary);
    box-shadow: 0 0 0 4px rgba(255, 210, 26, 0.1);
    background: rgba(11, 11, 13, 0.9);
}

.fe-form-input.error {
    border-color: #ef4444;
}

.fe-form-error {
    font-size: 11.5px;
    color: #fca5a5;
    margin-top: 6px;
    font-weight: 600;
}

/* MAP */
.fe-map-wrapper {
    border-radius: var(--fe-radius-xl);
    overflow: hidden;
    border: 1px solid var(--fe-border);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    position: relative;
}

.fe-map-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 30%;
    right: 30%;
    height: 2px;
    background: linear-gradient(90deg, transparent, var(--fe-primary), transparent);
    z-index: 1;
    box-shadow: 0 0 20px var(--fe-primary);
}

.fe-map-wrapper iframe {
    width: 100%;
    height: 450px;
    border: 0;
    display: block;
    filter: invert(0.9) hue-rotate(180deg) saturate(0.8);
    transition: filter 0.4s ease;
}

.fe-map-wrapper iframe:hover {
    filter: invert(0) hue-rotate(0) saturate(1);
}

@media (max-width: 767.98px) {
    .fe-contact-form-card {
        padding: 28px 22px;
    }
    .fe-form-title {
        font-size: 20px;
    }
    .fe-map-wrapper iframe {
        height: 320px;
    }
}
</style>
@endpush