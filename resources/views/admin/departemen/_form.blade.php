<div class="row g-4">

    {{-- SECTION: IDENTITAS --}}
    <div class="col-12">
        <div class="form-section-title">Identitas Departemen</div>
    </div>

    <div class="col-md-8">
        <label for="nama" class="form-label">Nama Departemen <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="nama"
            name="nama"
            class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('nama', $departemen->nama ?? '') }}"
            placeholder="Contoh: Departemen Internal"
            required
        >
        @error('nama')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="kode" class="form-label">Kode <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="kode"
            name="kode"
            class="form-control @error('kode') is-invalid @enderror"
            value="{{ old('kode', $departemen->kode ?? '') }}"
            placeholder="Contoh: INT"
            maxlength="20"
            required
        >
        @error('kode')
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
            value="{{ old('slug', $departemen->slug ?? '') }}"
            placeholder="Akan dibuat otomatis jika dikosongkan"
        >
        @error('slug')
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
            value="{{ old('urutan', $departemen->urutan ?? 0) }}"
            min="0"
        >
        @error('urutan')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea
            id="deskripsi"
            name="deskripsi"
            rows="5"
            class="form-control @error('deskripsi') is-invalid @enderror"
            placeholder="Jelaskan fungsi dan tugas departemen..."
        >{{ old('deskripsi', $departemen->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: TAMPILAN --}}
    <div class="col-12">
        <div class="form-section-title">Tampilan</div>
    </div>

    <div class="col-md-6">
        <label for="warna" class="form-label">Warna</label>
        <div class="d-flex gap-2">
            <input
                type="color"
                id="warna_picker"
                value="{{ old('warna', $departemen->warna ?? '#FFD21A') }}"
                style="
                    width: 48px;
                    height: 42px;
                    padding: 3px;
                    background: var(--card);
                    border: 1px solid var(--border);
                    border-radius: 9px;
                    cursor: pointer;
                "
            >
            <input
                type="text"
                id="warna"
                name="warna"
                class="form-control @error('warna') is-invalid @enderror"
                value="{{ old('warna', $departemen->warna ?? '#FFD21A') }}"
                placeholder="#FFD21A"
            >
        </div>
        @error('warna')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="icon" class="form-label">Icon (Bootstrap Icons)</label>
        <input
            type="text"
            id="icon"
            name="icon"
            class="form-control @error('icon') is-invalid @enderror"
            value="{{ old('icon', $departemen->icon ?? 'bi-diagram-3-fill') }}"
            placeholder="Contoh: bi-people-fill"
        >
        <div class="form-text">
            Lihat daftar di <a href="https://icons.getbootstrap.com/" target="_blank" style="color: var(--primary);">icons.getbootstrap.com</a>
        </div>
        @error('icon')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: STATUS --}}
    <div class="col-12">
        <div class="form-section-title">Status</div>
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Status <span style="color: var(--primary);">*</span></label>
        <select
            id="status"
            name="status"
            class="form-select @error('status') is-invalid @enderror"
            required
        >
            <option value="active" @selected(old('status', $departemen->status ?? 'active') === 'active')>
                Aktif
            </option>
            <option value="inactive" @selected(old('status', $departemen->status ?? '') === 'inactive')>
                Tidak Aktif
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.departemen.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($departemen) ? 'Simpan Perubahan' : 'Simpan Departemen' }}
    </button>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const picker = document.getElementById('warna_picker');
    const input = document.getElementById('warna');

    if (!picker || !input) return;

    picker.addEventListener('input', function () {
        input.value = this.value;
    });

    input.addEventListener('input', function () {
        const value = this.value.trim();
        if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
            picker.value = value;
        }
    });
});
</script>
@endpush