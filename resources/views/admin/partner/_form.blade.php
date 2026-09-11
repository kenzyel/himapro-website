<div class="row g-4">

    {{-- SECTION: INFORMASI --}}
    <div class="col-12">
        <div class="form-section-title">Informasi Partner</div>
    </div>

    <div class="col-md-8">
        <label for="nama" class="form-label">Nama Partner <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="nama"
            name="nama"
            class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('nama', $partner->nama ?? '') }}"
            placeholder="Contoh: PT Teknologi Nusantara"
            required
        >
        @error('nama')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="urutan" class="form-label">Urutan</label>
        <input
            type="number"
            id="urutan"
            name="urutan"
            class="form-control @error('urutan') is-invalid @enderror"
            value="{{ old('urutan', $partner->urutan ?? 0) }}"
            min="0"
        >
        <div class="form-text">Kecil = tampil lebih dulu.</div>
        @error('urutan')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8">
        <label for="slug" class="form-label">Slug</label>
        <input
            type="text"
            id="slug"
            name="slug"
            class="form-control @error('slug') is-invalid @enderror"
            value="{{ old('slug', $partner->slug ?? '') }}"
            placeholder="Otomatis dari nama jika kosong"
        >
        @error('slug')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="status" class="form-label">Status <span style="color: var(--primary);">*</span></label>
        <select
            id="status"
            name="status"
            class="form-select @error('status') is-invalid @enderror"
            required
        >
            <option value="active" @selected(old('status', $partner->status ?? 'active') === 'active')>
                Aktif
            </option>
            <option value="inactive" @selected(old('status', $partner->status ?? '') === 'inactive')>
                Non-Aktif
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="website" class="form-label">Website</label>
        <input
            type="url"
            id="website"
            name="website"
            class="form-control @error('website') is-invalid @enderror"
            value="{{ old('website', $partner->website ?? '') }}"
            placeholder="https://example.com"
        >
        @error('website')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea
            id="deskripsi"
            name="deskripsi"
            rows="4"
            class="form-control @error('deskripsi') is-invalid @enderror"
            placeholder="Jelaskan tentang partner ini..."
        >{{ old('deskripsi', $partner->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: LOGO --}}
    <div class="col-12">
        <div class="form-section-title">Logo</div>
    </div>

    <div class="col-md-6">
        <label for="logo" class="form-label">Upload Logo</label>

        @if (isset($partner) && $partner->logo)
            <div class="photo-preview mb-3">
                <img src="{{ asset('storage/' . $partner->logo) }}"
                     alt="{{ $partner->nama }}"
                     style="width: auto; height: 100px; object-fit: contain;">
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">
                    Logo saat ini. Pilih file baru untuk mengganti.
                </div>
            </div>
        @endif

        <input
            type="file"
            id="logo"
            name="logo"
            class="form-control @error('logo') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp,.svg,image/*"
        >
        <div class="form-text">Format JPG, PNG, WEBP, atau SVG. Maksimal 2 MB.</div>
        @error('logo')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <div id="logo-preview-container" class="d-none">
            <label class="form-label">Preview Logo Baru</label>
            <div class="photo-preview">
                <img id="logo-preview" src="" alt="Preview"
                     style="width: auto; height: 100px; object-fit: contain;">
            </div>
        </div>
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.partner.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($partner) ? 'Simpan Perubahan' : 'Simpan Partner' }}
    </button>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('logo');
    const container = document.getElementById('logo-preview-container');
    const img = document.getElementById('logo-preview');

    if (!input || !container || !img) return;

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (!file || !file.type.startsWith('image/')) {
            container.classList.add('d-none');
            img.src = '';
            return;
        }

        const url = URL.createObjectURL(file);
        img.src = url;
        container.classList.remove('d-none');

        img.onload = () => URL.revokeObjectURL(url);
    });
});
</script>
@endpush