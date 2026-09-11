@extends('layouts.admin')

@section('title', 'Edit ' . $section->name)

@php
    $canUpdate = auth()->user()->hasPermission('settings.update');
    $content = $section->content ?? [];

    // Tentukan URL preview berdasarkan key section
    $previewUrl = match ($section->key) {
        'hero', 'about', 'program_kerja', 'agenda', 'pengumuman', 'gallery', 'partner', 'cta', 'navbar', 'footer' => route('home'),
        'about_page' => route('frontend.about'),
        'visi_misi' => route('frontend.about.visi-misi'),
        'sejarah' => route('frontend.about.sejarah'),
        'contact_page' => route('frontend.contact'),
        default => route('home'),
    };
@endphp

@section('content')

{{-- HEADER --}}
<a href="{{ route('admin.landing-page.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Landing Page
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $section->name }}</h1>
        <p>Edit konten section ini. Preview di kanan akan refresh otomatis setelah disimpan.</p>
    </div>

    <div class="d-flex flex-wrap gap-2">
        <button type="button"
                class="btn-himapro btn-himapro-secondary no-print"
                onclick="togglePreview()"
                id="previewToggleBtn">
            <i class="bi bi-eye-slash" id="previewToggleIcon"></i>
            <span id="previewToggleText">Sembunyikan Preview</span>
        </button>

        <a href="{{ $previewUrl }}"
           target="_blank"
           class="btn-himapro btn-himapro-secondary no-print">
            <i class="bi bi-box-arrow-up-right"></i>
            Buka di Tab Baru
        </a>
    </div>
</div>


{{-- ERROR --}}
@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif


{{-- SPLIT VIEW --}}
<div class="lp-split-view" id="lpSplitView">

    {{-- LEFT: FORM --}}
    <div class="lp-form-panel" id="lpFormPanel">

        <form action="{{ route('admin.landing-page.update', $section) }}" method="POST" id="lpForm">
            @csrf
            @method('PUT')

            {{-- INFO SECTION --}}
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="card-header">
                    <h2 class="admin-card-title">Informasi Section</h2>
                    <p class="card-subtitle">Nama teknis dan status</p>
                </div>
                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label">Nama Section</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ $section->name }}"
                                   readonly
                                   style="opacity: 0.7;">
                            <div class="form-text">Kode internal: <code>{{ $section->key }}</code></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-select" {{ $canUpdate ? '' : 'disabled' }}>
                                <option value="1" @selected(old('is_active', $section->is_active))>Aktif — tampil di website</option>
                                <option value="0" @selected(!old('is_active', $section->is_active))>Non-Aktif — disembunyikan</option>
                            </select>
                        </div>

                    </div>

                </div>
            </div>


            {{-- FORM DINAMIS --}}
            <div class="admin-card mb-4" data-aos="fade-up">
                <div class="card-header">
                    <h2 class="admin-card-title">Konten Section</h2>
                    <p class="card-subtitle">Ubah teks dan pengaturan untuk section ini</p>
                </div>
                <div class="card-body">

                    @if ($section->key === 'hero')
                        @include('admin.landing-page.forms.hero')
                    @elseif ($section->key === 'about')
                        @include('admin.landing-page.forms.about')
                    @elseif ($section->key === 'program_kerja')
                        @include('admin.landing-page.forms.program-kerja')
                    @elseif ($section->key === 'agenda')
                        @include('admin.landing-page.forms.agenda')
                    @elseif ($section->key === 'pengumuman')
                        @include('admin.landing-page.forms.pengumuman')
                    @elseif ($section->key === 'gallery')
                        @include('admin.landing-page.forms.gallery')
                    @elseif ($section->key === 'partner')
                        @include('admin.landing-page.forms.partner')
                    @elseif ($section->key === 'cta')
                        @include('admin.landing-page.forms.cta')
                    @elseif ($section->key === 'about_page')
                        @include('admin.landing-page.forms.about-page')
                    @elseif ($section->key === 'visi_misi')
                        @include('admin.landing-page.forms.visi-misi')
                    @elseif ($section->key === 'sejarah')
                        @include('admin.landing-page.forms.sejarah')
                    @elseif ($section->key === 'contact_page')
                        @include('admin.landing-page.forms.contact-page')
                    @elseif ($section->key === 'navbar')
                        @include('admin.landing-page.forms.navbar')
                    @elseif ($section->key === 'footer')
                        @include('admin.landing-page.forms.footer')
                    @else
                        <div style="padding: 20px; text-align: center; color: var(--muted);">
                            Form untuk section ini belum dibuat.
                        </div>
                    @endif

                </div>
            </div>


            {{-- ACTION BUTTONS --}}
            @if ($canUpdate)
                <div class="d-flex justify-content-end gap-2" data-aos="fade-up">
                    <a href="{{ route('admin.landing-page.index') }}" class="btn-himapro btn-himapro-secondary">
                        <i class="bi bi-x-lg"></i>
                        Batal
                    </a>

                    <button type="submit" class="btn-himapro btn-himapro-primary" id="lpSaveBtn">
                        <i class="bi bi-check-lg"></i>
                        Simpan Perubahan
                    </button>
                </div>
            @else
                <div class="d-flex justify-content-end gap-2" data-aos="fade-up">
                    <a href="{{ route('admin.landing-page.index') }}" class="btn-himapro btn-himapro-secondary">
                        <i class="bi bi-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            @endif

        </form>

    </div>


    {{-- RIGHT: PREVIEW --}}
    <div class="lp-preview-panel" id="lpPreviewPanel">

        <div class="lp-preview-header">

            <div class="lp-preview-title">
                <i class="bi bi-eye-fill"></i>
                Preview
            </div>

            <div class="lp-preview-devices" id="lpPreviewDevices">

                <button type="button"
                        class="lp-device-btn active"
                        data-device="desktop"
                        title="Desktop">
                    <i class="bi bi-display"></i>
                </button>

                <button type="button"
                        class="lp-device-btn"
                        data-device="tablet"
                        title="Tablet">
                    <i class="bi bi-tablet"></i>
                </button>

                <button type="button"
                        class="lp-device-btn"
                        data-device="mobile"
                        title="Mobile">
                    <i class="bi bi-phone"></i>
                </button>

            </div>

            <button type="button"
                    class="lp-preview-refresh"
                    onclick="refreshPreview()"
                    title="Refresh Preview">
                <i class="bi bi-arrow-clockwise"></i>
            </button>

        </div>

        <div class="lp-preview-body">

            <div class="lp-preview-frame-wrapper" id="lpPreviewFrameWrapper" data-device="desktop">
                <iframe
                    src="{{ $previewUrl }}"
                    class="lp-preview-frame"
                    id="lpPreviewFrame"
                    title="Preview"
                ></iframe>
            </div>

        </div>

    </div>

</div>

@endsection


@push('styles')
<style>
/* =========================================================
   SPLIT VIEW
   ========================================================= */

.lp-split-view {
    display: grid;
    grid-template-columns: 40fr 60fr;
    gap: 24px;
    align-items: start;
}

.lp-form-panel {
    min-width: 0;
}

.lp-preview-panel {
    position: sticky;
    top: 90px;
    display: flex;
    flex-direction: column;
    height: calc(100vh - 120px);
    max-height: 800px;
    border-radius: var(--radius-lg);
    background: var(--card);
    border: 1px solid var(--border);
    overflow: hidden;
    box-shadow: var(--shadow-card);
    transition: all 0.3s ease;
}

/* Hidden state */
.lp-split-view.preview-hidden {
    grid-template-columns: 1fr;
}

.lp-split-view.preview-hidden .lp-preview-panel {
    display: none;
}

/* =========================================================
   PREVIEW HEADER
   ========================================================= */

.lp-preview-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    background: rgba(0, 0, 0, 0.3);
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
}

.lp-preview-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12.5px;
    font-weight: 800;
    color: var(--text);
    letter-spacing: 0.02em;
    flex: 1;
}

.lp-preview-title i {
    color: var(--primary);
    font-size: 14px;
}

.lp-preview-devices {
    display: flex;
    gap: 4px;
    padding: 3px;
    border-radius: 9px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--border);
}

.lp-device-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 0;
    border-radius: 7px;
    background: transparent;
    color: var(--muted);
    font-size: 14px;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
}

.lp-device-btn:hover {
    color: var(--text);
    background: rgba(255, 255, 255, 0.05);
}

.lp-device-btn.active {
    background: var(--primary);
    color: #111;
    box-shadow: 0 2px 12px rgba(255, 210, 26, 0.4);
}

.lp-preview-refresh {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 9px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--border);
    color: var(--text);
    font-size: 15px;
    cursor: pointer;
    transition: all 0.2s ease;
    padding: 0;
}

.lp-preview-refresh:hover {
    background: rgba(255, 210, 26, 0.1);
    border-color: rgba(255, 210, 26, 0.35);
    color: var(--primary);
    transform: rotate(45deg);
}

.lp-preview-refresh.spinning i {
    animation: lpSpin 0.6s ease-in-out;
}

@keyframes lpSpin {
    to { transform: rotate(360deg); }
}

/* =========================================================
   PREVIEW BODY
   ========================================================= */

.lp-preview-body {
    flex: 1;
    padding: 18px;
    overflow: auto;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    background:
        repeating-linear-gradient(
            45deg,
            rgba(255, 255, 255, 0.02) 0,
            rgba(255, 255, 255, 0.02) 10px,
            transparent 10px,
            transparent 20px
        ),
        rgba(0, 0, 0, 0.2);
}

.lp-preview-frame-wrapper {
    width: 100%;
    height: 100%;
    border-radius: 12px;
    background: #0B0B0D;
    border: 1px solid var(--border-strong);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.5);
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    margin: 0 auto;
    position: relative;
}

.lp-preview-frame {
    width: 100%;
    height: 100%;
    border: 0;
    display: block;
    background: #0B0B0D;
}

/* Device modes */
.lp-preview-frame-wrapper[data-device="desktop"] {
    width: 100%;
    max-width: 100%;
}

.lp-preview-frame-wrapper[data-device="tablet"] {
    width: 768px;
    max-width: 100%;
    height: 90%;
}

.lp-preview-frame-wrapper[data-device="mobile"] {
    width: 375px;
    max-width: 100%;
    height: 85%;
}

/* Loading overlay */
.lp-preview-frame-wrapper::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(11, 11, 13, 0.8);
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
}

.lp-preview-frame-wrapper.loading::after {
    opacity: 1;
}

/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 1399.98px) {
    .lp-split-view {
        grid-template-columns: 45fr 55fr;
    }
}

@media (max-width: 1199.98px) {
    .lp-split-view {
        grid-template-columns: 1fr;
    }

    .lp-preview-panel {
        position: static;
        height: 600px;
        max-height: 600px;
    }

    .lp-split-view.preview-hidden .lp-preview-panel {
        display: none;
    }
}

@media (max-width: 767.98px) {
    .lp-preview-frame-wrapper[data-device="desktop"],
    .lp-preview-frame-wrapper[data-device="tablet"] {
        width: 100%;
        height: 100%;
    }

    .lp-preview-frame-wrapper[data-device="mobile"] {
        width: 100%;
        height: 100%;
    }
}
</style>
@endpush


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const splitView = document.getElementById('lpSplitView');
    const toggleBtn = document.getElementById('previewToggleBtn');
    const toggleIcon = document.getElementById('previewToggleIcon');
    const toggleText = document.getElementById('previewToggleText');
    const frame = document.getElementById('lpPreviewFrame');
    const frameWrapper = document.getElementById('lpPreviewFrameWrapper');
    const refreshBtn = document.querySelector('.lp-preview-refresh');
    const deviceBtns = document.querySelectorAll('.lp-device-btn');
    const form = document.getElementById('lpForm');

    /*
    |--------------------------------------------------------------------------
    | TOGGLE PREVIEW
    |--------------------------------------------------------------------------
    */
    window.togglePreview = function () {
        splitView.classList.toggle('preview-hidden');

        const isHidden = splitView.classList.contains('preview-hidden');

        localStorage.setItem('lp-preview-hidden', isHidden ? '1' : '0');

        if (isHidden) {
            toggleIcon.className = 'bi bi-eye';
            toggleText.textContent = 'Tampilkan Preview';
        } else {
            toggleIcon.className = 'bi bi-eye-slash';
            toggleText.textContent = 'Sembunyikan Preview';
        }
    };

    // Restore state
    if (localStorage.getItem('lp-preview-hidden') === '1') {
        splitView.classList.add('preview-hidden');
        toggleIcon.className = 'bi bi-eye';
        toggleText.textContent = 'Tampilkan Preview';
    }

    /*
    |--------------------------------------------------------------------------
    | REFRESH PREVIEW
    |--------------------------------------------------------------------------
    */
    window.refreshPreview = function () {
        if (!frame) return;

        if (refreshBtn) {
            refreshBtn.classList.add('spinning');
            setTimeout(() => refreshBtn.classList.remove('spinning'), 600);
        }

        frameWrapper?.classList.add('loading');

        const currentSrc = frame.src;
        frame.src = 'about:blank';

        setTimeout(() => {
            frame.src = currentSrc;

            frame.onload = () => {
                frameWrapper?.classList.remove('loading');
            };

            setTimeout(() => frameWrapper?.classList.remove('loading'), 2000);
        }, 100);
    };

    /*
    |--------------------------------------------------------------------------
    | DEVICE SELECTOR
    |--------------------------------------------------------------------------
    */
    deviceBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const device = this.dataset.device;

            deviceBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            frameWrapper.dataset.device = device;

            localStorage.setItem('lp-preview-device', device);
        });
    });

    // Restore device preference
    const savedDevice = localStorage.getItem('lp-preview-device');
    if (savedDevice) {
        const btn = document.querySelector(`.lp-device-btn[data-device="${savedDevice}"]`);
        if (btn) btn.click();
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO REFRESH SETELAH SAVE
    |--------------------------------------------------------------------------
    */
    if (form) {
        form.addEventListener('submit', function () {
            sessionStorage.setItem('lp-need-refresh', '1');
        });
    }

    if (sessionStorage.getItem('lp-need-refresh') === '1') {
        sessionStorage.removeItem('lp-need-refresh');
        setTimeout(() => {
            refreshPreview();
        }, 500);
    }

});
</script>
@endpush