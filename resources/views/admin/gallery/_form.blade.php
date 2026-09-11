<div class="row g-4">

    {{-- SECTION: INFORMASI --}}
    <div class="col-12">
        <div class="form-section-title">Informasi Gallery</div>
    </div>

    <div class="col-md-8">
        <label for="nama" class="form-label">Nama Gallery <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="nama"
            name="nama"
            class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('nama', $gallery->nama ?? '') }}"
            placeholder="Contoh: Rapat Kerja HIMAPRO TI SAKTI 2026"
            required
        >
        @error('nama')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="tanggal" class="form-label">Tanggal</label>
        <input
            type="date"
            id="tanggal"
            name="tanggal"
            class="form-control @error('tanggal') is-invalid @enderror"
            value="{{ old('tanggal', isset($gallery) && $gallery->tanggal ? $gallery->tanggal->format('Y-m-d') : '') }}"
        >
        @error('tanggal')
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
            value="{{ old('slug', $gallery->slug ?? '') }}"
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
            <option value="draft" @selected(old('status', $gallery->status ?? 'draft') === 'draft')>
                Draft
            </option>
            <option value="published" @selected(old('status', $gallery->status ?? '') === 'published')>
                Published
            </option>
            <option value="archived" @selected(old('status', $gallery->status ?? '') === 'archived')>
                Archived
            </option>
        </select>
        @error('status')
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
            placeholder="Tuliskan deskripsi gallery..."
        >{{ old('deskripsi', $gallery->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: COVER --}}
    <div class="col-12">
        <div class="form-section-title">Cover Gallery</div>
    </div>

    <div class="col-md-6">
        <label for="cover" class="form-label">File Cover</label>

        @if (isset($gallery) && $gallery->cover)
            <div class="photo-preview mb-3">
                <img src="{{ asset('storage/' . $gallery->cover) }}" alt="{{ $gallery->nama }}">
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">
                    Cover saat ini. Pilih file baru untuk mengganti.
                </div>
            </div>
        @endif

        <input
            type="file"
            id="cover"
            name="cover"
            class="form-control @error('cover') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp,image/*"
        >
        <div class="form-text">Format JPG, JPEG, PNG, WEBP. Maksimal 5 MB.</div>
        @error('cover')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <div id="cover-preview-container" class="d-none">
            <label class="form-label">Preview Cover Baru</label>
            <div class="photo-preview">
                <img id="cover-preview" src="" alt="Preview" style="width: 100%; max-width: 260px; height: auto; max-height: 200px; object-fit: cover;">
            </div>
        </div>
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.gallery.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($gallery) ? 'Simpan Perubahan' : 'Simpan Gallery' }}
    </button>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('cover');
    const container = document.getElementById('cover-preview-container');
    const img = document.getElementById('cover-preview');

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