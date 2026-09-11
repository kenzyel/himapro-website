<div class="row g-4">

    {{-- SECTION: INFORMASI DOKUMEN --}}
    <div class="col-12">
        <div class="form-section-title">Informasi Dokumen</div>
    </div>

    <div class="col-md-8">
        <label for="nama" class="form-label">Nama Dokumen <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="nama"
            name="nama"
            class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('nama', $dokumen->nama ?? '') }}"
            placeholder="Contoh: Proposal Kegiatan Seminar 2026"
            required
        >
        @error('nama')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="kategori" class="form-label">Kategori <span style="color: var(--primary);">*</span></label>
        <select
            id="kategori"
            name="kategori"
            class="form-select @error('kategori') is-invalid @enderror"
            required
        >
            <option value="">— Pilih Kategori —</option>
            @foreach ($kategoris as $key => $label)
                <option value="{{ $key }}" @selected(old('kategori', $dokumen->kategori ?? '') === $key)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('kategori')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8">
        <label for="periode" class="form-label">Periode</label>
        <input
            type="text"
            id="periode"
            name="periode"
            class="form-control @error('periode') is-invalid @enderror"
            value="{{ old('periode', $dokumen->periode ?? '2026/2027') }}"
            placeholder="2026/2027"
        >
        @error('periode')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="is_public" class="form-label">Publikasi</label>
        <div class="form-check form-switch" style="padding-top: 8px;">
            <input type="hidden" name="is_public" value="0">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="is_public"
                name="is_public"
                value="1"
                @checked(old('is_public', isset($dokumen) ? $dokumen->is_public : false))
            >
            <label class="form-check-label" for="is_public" style="font-size: 13px;">
                Tampilkan di website publik
            </label>
        </div>
        @error('is_public')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="deskripsi" class="form-label">Deskripsi</label>
        <textarea
            id="deskripsi"
            name="deskripsi"
            rows="3"
            class="form-control @error('deskripsi') is-invalid @enderror"
            placeholder="Deskripsi singkat tentang dokumen ini..."
        >{{ old('deskripsi', $dokumen->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: FILE --}}
    <div class="col-12">
        <div class="form-section-title">File Dokumen</div>
    </div>

    <div class="col-md-6">
        <label for="file" class="form-label">
            File <span style="color: var(--primary);">{{ isset($dokumen) ? '' : '*' }}</span>
        </label>

        @if (isset($dokumen) && $dokumen->file_path)
            <div class="photo-preview mb-3">
                <div style="display: flex; align-items: center; gap: 12px; justify-content: center;">
                    <i class="bi bi-file-earmark-text" style="font-size: 40px; color: var(--primary);"></i>
                    <div style="text-align: left;">
                        <div style="font-weight: 700; font-size: 13px;">
                            {{ $dokumen->file_name }}
                        </div>
                        <div style="font-size: 11px; color: var(--muted);">
                            {{ number_format($dokumen->file_size / 1024, 0) }} KB
                            · {{ $dokumen->mime_type }}
                        </div>
                        <a href="{{ asset('storage/' . $dokumen->file_path) }}"
                           target="_blank"
                           style="color: var(--primary); font-size: 11.5px; text-decoration: none;">
                            <i class="bi bi-download"></i>
                            Unduh file
                        </a>
                    </div>
                </div>
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">
                    File saat ini. Pilih file baru untuk mengganti.
                </div>
            </div>
        @endif

        <input
            type="file"
            id="file"
            name="file"
            class="form-control @error('file') is-invalid @enderror"
            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.rar"
            {{ isset($dokumen) ? '' : 'required' }}
        >
        <div class="form-text">
            Format: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT, ZIP, RAR. Maksimal 10 MB.
        </div>
        @error('file')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <div id="file-preview-container" class="d-none">
            <label class="form-label">File Baru Dipilih</label>
            <div class="photo-preview">
                <div style="display: flex; align-items: center; gap: 12px; justify-content: center;">
                    <i class="bi bi-file-earmark-check" style="font-size: 40px; color: #86efac;"></i>
                    <div style="text-align: left;">
                        <div id="file-preview-name" style="font-weight: 700; font-size: 13px;"></div>
                        <div id="file-preview-size" style="font-size: 11px; color: var(--muted);"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.dokumen.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-cloud-upload"></i>
        {{ isset($dokumen) ? 'Simpan Perubahan' : 'Upload Dokumen' }}
    </button>
</div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('file');
    const container = document.getElementById('file-preview-container');
    const nameEl = document.getElementById('file-preview-name');
    const sizeEl = document.getElementById('file-preview-size');

    if (!input || !container) return;

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (!file) {
            container.classList.add('d-none');
            return;
        }

        nameEl.textContent = file.name;
        sizeEl.textContent = (file.size / 1024).toFixed(0) + ' KB';
        container.classList.remove('d-none');
    });
});
</script>
@endpush