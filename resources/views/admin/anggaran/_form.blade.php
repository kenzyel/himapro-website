<div class="row g-4">

    {{-- SECTION: INFORMASI ANGGARAN --}}
    <div class="col-12">
        <div class="form-section-title">Informasi Anggaran</div>
    </div>

    <div class="col-md-8">
        <label for="nama" class="form-label">Nama Anggaran <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="nama"
            name="nama"
            class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('nama', $anggaran->nama ?? '') }}"
            placeholder="Contoh: Konsumsi Seminar Nasional"
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
            value="{{ old('periode', $anggaran->periode ?? '2026/2027') }}"
            placeholder="2026/2027"
            required
        >
        @error('periode')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: RELASI --}}
    <div class="col-12">
        <div class="form-section-title">Keterkaitan</div>
    </div>

    <div class="col-md-6">
        <label for="departemen_id" class="form-label">Departemen</label>
        <select
            id="departemen_id"
            name="departemen_id"
            class="form-select @error('departemen_id') is-invalid @enderror"
        >
            <option value="">— Tidak terkait departemen —</option>
            @foreach ($departemens as $departemen)
                <option value="{{ $departemen->id }}" @selected(old('departemen_id', $anggaran->departemen_id ?? '') == $departemen->id)>
                    {{ $departemen->nama }}
                </option>
            @endforeach
        </select>
        @error('departemen_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="program_kerja_id" class="form-label">Program Kerja</label>
        <select
            id="program_kerja_id"
            name="program_kerja_id"
            class="form-select @error('program_kerja_id') is-invalid @enderror"
        >
            <option value="">— Tidak terkait program kerja —</option>
            @foreach ($programKerjas as $programKerja)
                <option value="{{ $programKerja->id }}" @selected(old('program_kerja_id', $anggaran->program_kerja_id ?? '') == $programKerja->id)>
                    {{ $programKerja->nama }}
                </option>
            @endforeach
        </select>
        @error('program_kerja_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: NOMINAL & STATUS --}}
    <div class="col-12">
        <div class="form-section-title">Nominal & Status</div>
    </div>

    <div class="col-md-6">
        <label for="jumlah" class="form-label">Jumlah Anggaran <span style="color: var(--primary);">*</span></label>
        <input
            type="number"
            id="jumlah"
            name="jumlah"
            class="form-control @error('jumlah') is-invalid @enderror"
            value="{{ old('jumlah', $anggaran->jumlah ?? 0) }}"
            min="0"
            step="0.01"
            placeholder="0"
            required
        >
        <div id="jumlah-preview" class="form-text" style="color: var(--primary); font-weight: 700;">
            Rp 0
        </div>
        @error('jumlah')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="status" class="form-label">Status <span style="color: var(--primary);">*</span></label>
        <select
            id="status"
            name="status"
            class="form-select @error('status') is-invalid @enderror"
            required
        >
            <option value="draft" @selected(old('status', $anggaran->status ?? 'draft') === 'draft')>
                Draft
            </option>
            <option value="approved" @selected(old('status', $anggaran->status ?? '') === 'approved')>
                Disetujui
            </option>
            <option value="realized" @selected(old('status', $anggaran->status ?? '') === 'realized')>
                Realisasi
            </option>
            <option value="cancelled" @selected(old('status', $anggaran->status ?? '') === 'cancelled')>
                Dibatalkan
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea
            id="keterangan"
            name="keterangan"
            rows="3"
            class="form-control @error('keterangan') is-invalid @enderror"
            placeholder="Catatan tambahan tentang anggaran ini..."
        >{{ old('keterangan', $anggaran->keterangan ?? '') }}</textarea>
        @error('keterangan')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.anggaran.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($anggaran) ? 'Simpan Perubahan' : 'Simpan Anggaran' }}
    </button>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('jumlah');
    const preview = document.getElementById('jumlah-preview');

    if (!input || !preview) return;

    function update() {
        const value = parseFloat(input.value) || 0;
        preview.textContent = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
        }).format(value);
    }

    input.addEventListener('input', update);
    update();
});
</script>
@endpush