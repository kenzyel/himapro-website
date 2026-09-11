@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')

@php
    $canUpdate = auth()->user()->hasPermission('settings.update');
@endphp

<div class="page-header" data-aos="fade-down">
    <h1>Pengaturan</h1>
    <p>Kelola konfigurasi umum sistem HIMAPRO TI SAKTI.</p>
</div>


@if (session('success'))
    <div class="alert alert-success alert-dismissible" data-aos="fade-down">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible" data-aos="fade-down">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" data-aos="fade-down">
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


@if (! $canUpdate)
    <div class="alert alert-warning" data-aos="fade-down" style="margin-bottom: 22px;">
        <i class="bi bi-info-circle-fill"></i>
        <div>
            Anda hanya dapat <strong>melihat</strong> pengaturan. Hubungi administrator untuk mengubah.
        </div>
    </div>
@endif


@if ($settings->count() > 0)

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        @foreach ($settings as $group => $items)

            <div class="admin-card mb-4" data-aos="fade-up">

                <div class="card-header">
                    <div>
                        <h2 class="admin-card-title">
                            {{ ucfirst(str_replace('-', ' ', $group)) }}
                        </h2>
                        <p class="card-subtitle">
                            {{ $items->count() }} pengaturan dalam grup ini
                        </p>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row g-4">

                        @foreach ($items as $setting)

                            {{-- Khusus site_logo --}}
                            @if ($setting->key === 'site_logo')
                                <div class="col-md-6">
                                    <label class="form-label">Logo Website</label>

                                    <div class="setting-logo-preview" id="logo-preview-container">
                                        @if ($setting->value)
                                            <img
                                                src="{{ asset('storage/' . $setting->value) }}"
                                                alt="Logo"
                                                id="logo-preview"
                                                class="setting-logo-img"
                                            >
                                        @else
                                            <div class="setting-logo-placeholder" id="logo-placeholder">
                                                <i class="bi bi-image"></i>
                                                <span>Belum ada logo</span>
                                            </div>
                                            <img
                                                src=""
                                                alt="Logo"
                                                id="logo-preview"
                                                class="setting-logo-img"
                                                style="display: none;"
                                            >
                                        @endif
                                    </div>

                                    @if ($setting->value)
                                        <div class="form-check mt-2">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="remove_site_logo"
                                                value="1"
                                                id="remove_site_logo"
                                                {{ $canUpdate ? '' : 'disabled' }}
                                            >
                                            <label class="form-check-label" for="remove_site_logo" style="font-size: 12.5px;">
                                                Hapus logo saat ini
                                            </label>
                                        </div>
                                    @endif

                                    <input
                                        type="file"
                                        name="site_logo_file"
                                        id="site_logo_file"
                                        class="form-control mt-2 @error('site_logo_file') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp,.svg,image/*"
                                        {{ $canUpdate ? '' : 'disabled' }}
                                    >

                                    <div class="form-text">
                                        Format: JPG, PNG, WEBP, SVG. Maksimal 2 MB.
                                        <br>
                                        Rekomendasi: logo persegi atau horizontal dengan background transparan.
                                    </div>

                                    @error('site_logo_file')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            {{-- Khusus site_favicon --}}
                            @elseif ($setting->key === 'site_favicon')
                                <div class="col-md-6">
                                    <label class="form-label">Favicon Website</label>

                                    <div class="setting-logo-preview" style="height: 80px;">
                                        @if ($setting->value)
                                            <img
                                                src="{{ asset('storage/' . $setting->value) }}"
                                                alt="Favicon"
                                                style="max-height: 60px; max-width: 100%; object-fit: contain;"
                                            >
                                        @else
                                            <div class="setting-logo-placeholder" style="height: 80px;">
                                                <i class="bi bi-browser-chrome"></i>
                                                <span>Belum ada favicon</span>
                                            </div>
                                        @endif
                                    </div>

                                    @if ($setting->value)
                                        <div class="form-check mt-2">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="remove_site_favicon"
                                                value="1"
                                                id="remove_site_favicon"
                                                {{ $canUpdate ? '' : 'disabled' }}
                                            >
                                            <label class="form-check-label" for="remove_site_favicon" style="font-size: 12.5px;">
                                                Hapus favicon saat ini
                                            </label>
                                        </div>
                                    @endif

                                    <input
                                        type="file"
                                        name="site_favicon_file"
                                        class="form-control mt-2 @error('site_favicon_file') is-invalid @enderror"
                                        accept=".ico,.png,.jpg,.jpeg,.svg,.webp,image/*"
                                        {{ $canUpdate ? '' : 'disabled' }}
                                    >

                                    <div class="form-text">
                                        Format: ICO, PNG, SVG. Maksimal 512 KB.
                                    </div>

                                    @error('site_favicon_file')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            {{-- Setting biasa --}}
                            @else
                                <div class="col-md-6">
                                    <label for="setting-{{ $setting->id }}" class="form-label">
                                        {{ $setting->key }}
                                    </label>

                                    @if ($setting->type === 'textarea')
                                        <textarea
                                            id="setting-{{ $setting->id }}"
                                            name="settings[{{ $setting->key }}]"
                                            rows="4"
                                            class="form-control"
                                            placeholder="{{ $setting->description ?: $setting->key }}"
                                            {{ $canUpdate ? '' : 'readonly' }}
                                        >{{ old('settings.' . $setting->key, $setting->value) }}</textarea>

                                    @elseif ($setting->type === 'boolean')
                                        <select
                                            id="setting-{{ $setting->id }}"
                                            name="settings[{{ $setting->key }}]"
                                            class="form-select"
                                            {{ $canUpdate ? '' : 'disabled' }}
                                        >
                                            <option value="1" @selected(old('settings.' . $setting->key, $setting->value) == '1')>
                                                Aktif
                                            </option>
                                            <option value="0" @selected(old('settings.' . $setting->key, $setting->value) == '0')>
                                                Non-Aktif
                                            </option>
                                        </select>

                                    @else
                                        <input
                                            type="text"
                                            id="setting-{{ $setting->id }}"
                                            name="settings[{{ $setting->key }}]"
                                            class="form-control"
                                            value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                            placeholder="{{ $setting->description ?: $setting->key }}"
                                            {{ $canUpdate ? '' : 'readonly' }}
                                        >
                                    @endif

                                    @if ($setting->description)
                                        <div class="form-text">{{ $setting->description }}</div>
                                    @endif
                                </div>
                            @endif

                        @endforeach

                    </div>

                </div>

            </div>

        @endforeach


        {{-- SUBMIT BUTTON --}}
        @if ($canUpdate)
            <div class="d-flex justify-content-end gap-2" data-aos="fade-up">
                <button type="reset" class="btn-himapro btn-himapro-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i>
                    Reset
                </button>

                <button type="submit" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-check-lg"></i>
                    Simpan Pengaturan
                </button>
            </div>
        @else
            <div class="d-flex justify-content-end" data-aos="fade-up">
                <a href="{{ route('admin.dashboard') }}" class="btn-himapro btn-himapro-secondary">
                    <i class="bi bi-arrow-left"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        @endif

    </form>

@else

    <div class="admin-card" data-aos="fade-up">
        <div class="card-body">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-gear"></i>
                </div>
                <h6 class="fw-bold mb-2">Belum ada pengaturan</h6>
                <p class="mb-0">
                    Tambahkan data ke tabel <code>settings</code> lewat seeder atau migration.
                </p>
            </div>
        </div>
    </div>

@endif

@endsection


@push('styles')
<style>
.setting-logo-preview {
    padding: 20px;
    border-radius: var(--radius);
    background: rgba(255, 255, 255, 0.02);
    border: 1px dashed var(--border-strong);
    text-align: center;
    min-height: 140px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all var(--transition);
}

.setting-logo-preview:hover {
    border-color: var(--primary);
    background: rgba(255, 210, 26, 0.03);
}

.setting-logo-img {
    max-height: 100px;
    max-width: 100%;
    object-fit: contain;
}

.setting-logo-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: var(--muted);
    font-size: 12.5px;
}

.setting-logo-placeholder i {
    font-size: 32px;
    opacity: 0.4;
}
</style>
@endpush


@push('scripts')
@if ($canUpdate)
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Preview logo
    const logoInput = document.getElementById('site_logo_file');
    const logoPreview = document.getElementById('logo-preview');
    const logoPlaceholder = document.getElementById('logo-placeholder');

    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', function (e) {
            const file = e.target.files[0];

            if (!file || !file.type.startsWith('image/')) {
                return;
            }

            const url = URL.createObjectURL(file);
            logoPreview.src = url;
            logoPreview.style.display = 'block';

            if (logoPlaceholder) {
                logoPlaceholder.style.display = 'none';
            }

            logoPreview.onload = () => URL.revokeObjectURL(url);
        });
    }

});
</script>
@endif
@endpush