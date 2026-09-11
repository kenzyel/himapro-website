<div class="row g-4">

    {{-- SECTION: IDENTITAS --}}
    <div class="col-12">
        <div class="form-section-title">Identitas Program Kerja</div>
    </div>

    <div class="col-md-8">
        <label for="nama" class="form-label">Nama Program Kerja <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="nama"
            name="nama"
            class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('nama', $programKerja->nama ?? '') }}"
            placeholder="Contoh: Seminar Nasional Teknologi Informasi"
            required
        >
        @error('nama')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="periode" class="form-label">Periode <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="periode"
            name="periode"
            class="form-control @error('periode') is-invalid @enderror"
            value="{{ old('periode', $programKerja->periode ?? '2026/2027') }}"
            placeholder="2026/2027"
            required
        >
        @error('periode')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8">
        <label for="departemen_id" class="form-label">Departemen <span style="color: var(--primary);">*</span></label>
        <select
            id="departemen_id"
            name="departemen_id"
            class="form-select @error('departemen_id') is-invalid @enderror"
            required
        >
            <option value="">— Pilih Departemen —</option>
            @foreach ($departemens as $departemen)
                <option value="{{ $departemen->id }}"
                    @selected((string) old('departemen_id', $programKerja->departemen_id ?? '') === (string) $departemen->id)>
                    {{ $departemen->nama }} ({{ $departemen->kode }})
                </option>
            @endforeach
        </select>
        @error('departemen_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="slug" class="form-label">Slug</label>
        <input
            type="text"
            id="slug"
            name="slug"
            class="form-control @error('slug') is-invalid @enderror"
            value="{{ old('slug', $programKerja->slug ?? '') }}"
            placeholder="Otomatis dari nama"
        >
        @error('slug')
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
            placeholder="Jelaskan program kerja secara umum..."
        >{{ old('deskripsi', $programKerja->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: TUJUAN & TARGET --}}
    <div class="col-12">
        <div class="form-section-title">Tujuan & Target</div>
    </div>

    <div class="col-md-6">
        <label for="tujuan" class="form-label">Tujuan</label>
        <textarea
            id="tujuan"
            name="tujuan"
            rows="5"
            class="form-control @error('tujuan') is-invalid @enderror"
            placeholder="Apa tujuan program kerja ini?"
        >{{ old('tujuan', $programKerja->tujuan ?? '') }}</textarea>
        @error('tujuan')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="target" class="form-label">Target</label>
        <textarea
            id="target"
            name="target"
            rows="5"
            class="form-control @error('target') is-invalid @enderror"
            placeholder="Siapa atau apa target program kerja ini?"
        >{{ old('target', $programKerja->target ?? '') }}</textarea>
        @error('target')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: JADWAL & ANGGARAN --}}
    <div class="col-12">
        <div class="form-section-title">Jadwal & Anggaran</div>
    </div>

    <div class="col-md-4">
        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
        <input
            type="date"
            id="tanggal_mulai"
            name="tanggal_mulai"
            class="form-control @error('tanggal_mulai') is-invalid @enderror"
            value="{{ old('tanggal_mulai', isset($programKerja->tanggal_mulai) ? $programKerja->tanggal_mulai->format('Y-m-d') : '') }}"
        >
        @error('tanggal_mulai')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
        <input
            type="date"
            id="tanggal_selesai"
            name="tanggal_selesai"
            class="form-control @error('tanggal_selesai') is-invalid @enderror"
            value="{{ old('tanggal_selesai', isset($programKerja->tanggal_selesai) ? $programKerja->tanggal_selesai->format('Y-m-d') : '') }}"
        >
        @error('tanggal_selesai')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="anggaran" class="form-label">Anggaran</label>
        <input
            type="number"
            id="anggaran"
            name="anggaran"
            class="form-control @error('anggaran') is-invalid @enderror"
            value="{{ old('anggaran', $programKerja->anggaran ?? 0) }}"
            min="0"
            step="0.01"
            placeholder="0"
        >
        <div id="anggaran-preview" class="form-text" style="color: var(--primary); font-weight: 700;">
            Rp 0
        </div>
        @error('anggaran')
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
            <option value="planned" @selected(old('status', $programKerja->status ?? 'planned') === 'planned')>
                Direncanakan
            </option>
            <option value="ongoing" @selected(old('status', $programKerja->status ?? '') === 'ongoing')>
                Sedang Berjalan
            </option>
            <option value="completed" @selected(old('status', $programKerja->status ?? '') === 'completed')>
                Selesai
            </option>
            <option value="cancelled" @selected(old('status', $programKerja->status ?? '') === 'cancelled')>
                Dibatalkan
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.program-kerja.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($programKerja) ? 'Simpan Perubahan' : 'Simpan Program Kerja' }}
    </button>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const namaInput = document.getElementById('nama');
    const slugInput = document.getElementById('slug');
    const anggaranInput = document.getElementById('anggaran');
    const anggaranPreview = document.getElementById('anggaran-preview');

    let slugWasEdited = slugInput && slugInput.value !== '';

    if (slugInput) {
        slugInput.addEventListener('input', function () {
            slugWasEdited = true;
        });
    }

    if (namaInput && slugInput) {
        namaInput.addEventListener('input', function () {
            if (!slugWasEdited) {
                slugInput.value = this.value
                    .toLowerCase()
                    .trim()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-');
            }
        });
    }

    function updateAnggaranPreview() {
        if (!anggaranInput || !anggaranPreview) return;
        const value = parseFloat(anggaranInput.value) || 0;
        anggaranPreview.textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(value);
    }

    if (anggaranInput) {
        anggaranInput.addEventListener('input', updateAnggaranPreview);
        updateAnggaranPreview();
    }
});
</script>
@endpush