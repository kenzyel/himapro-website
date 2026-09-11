<div class="row g-4">

    {{-- SECTION: JENIS & NOMOR --}}
    <div class="col-12">
        <div class="form-section-title">Informasi Surat</div>
    </div>

    <div class="col-md-4">
        <label for="jenis" class="form-label">Jenis Surat <span style="color: var(--primary);">*</span></label>
        <select
            id="jenis"
            name="jenis"
            class="form-select @error('jenis') is-invalid @enderror"
            required
        >
            <option value="masuk" @selected(old('jenis', $surat->jenis ?? 'masuk') === 'masuk')>
                Surat Masuk
            </option>
            <option value="keluar" @selected(old('jenis', $surat->jenis ?? '') === 'keluar')>
                Surat Keluar
            </option>
        </select>
        @error('jenis')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="nomor_surat" class="form-label">Nomor Surat <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="nomor_surat"
            name="nomor_surat"
            class="form-control @error('nomor_surat') is-invalid @enderror"
            value="{{ old('nomor_surat', $surat->nomor_surat ?? '') }}"
            placeholder="001/HIMAPRO-TI/2026"
            required
        >
        @error('nomor_surat')
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
            <option value="draft" @selected(old('status', $surat->status ?? 'draft') === 'draft')>
                Draft
            </option>
            <option value="sent" @selected(old('status', $surat->status ?? '') === 'sent')>
                Terkirim
            </option>
            <option value="received" @selected(old('status', $surat->status ?? '') === 'received')>
                Diterima
            </option>
            <option value="archived" @selected(old('status', $surat->status ?? '') === 'archived')>
                Diarsipkan
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="perihal" class="form-label">Perihal <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="perihal"
            name="perihal"
            class="form-control @error('perihal') is-invalid @enderror"
            value="{{ old('perihal', $surat->perihal ?? '') }}"
            placeholder="Contoh: Undangan Rapat Koordinasi"
            required
        >
        @error('perihal')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: PENGIRIM & PENERIMA --}}
    <div class="col-12">
        <div class="form-section-title">Pengirim & Penerima</div>
    </div>

    <div class="col-md-6">
        <label for="pengirim" class="form-label">Pengirim</label>
        <input
            type="text"
            id="pengirim"
            name="pengirim"
            class="form-control @error('pengirim') is-invalid @enderror"
            value="{{ old('pengirim', $surat->pengirim ?? '') }}"
            placeholder="Contoh: Universitas XYZ"
        >
        @error('pengirim')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="penerima" class="form-label">Penerima</label>
        <input
            type="text"
            id="penerima"
            name="penerima"
            class="form-control @error('penerima') is-invalid @enderror"
            value="{{ old('penerima', $surat->penerima ?? '') }}"
            placeholder="Contoh: Ketua HIMAPRO TI SAKTI"
        >
        @error('penerima')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: TANGGAL --}}
    <div class="col-12">
        <div class="form-section-title">Tanggal</div>
    </div>

    <div class="col-md-6">
        <label for="tanggal_surat" class="form-label">Tanggal Surat <span style="color: var(--primary);">*</span></label>
        <input
            type="date"
            id="tanggal_surat"
            name="tanggal_surat"
            class="form-control @error('tanggal_surat') is-invalid @enderror"
            value="{{ old('tanggal_surat', isset($surat->tanggal_surat) ? $surat->tanggal_surat->format('Y-m-d') : '') }}"
            required
        >
        @error('tanggal_surat')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
        <input
            type="date"
            id="tanggal_terima"
            name="tanggal_terima"
            class="form-control @error('tanggal_terima') is-invalid @enderror"
            value="{{ old('tanggal_terima', isset($surat->tanggal_terima) ? $surat->tanggal_terima->format('Y-m-d') : '') }}"
        >
        <div class="form-text">Khusus surat masuk.</div>
        @error('tanggal_terima')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: FILE & KETERANGAN --}}
    <div class="col-12">
        <div class="form-section-title">File & Keterangan</div>
    </div>

    <div class="col-md-6">
        <label for="file" class="form-label">File Surat (opsional)</label>

        @if (isset($surat) && $surat->file_path)
            <div class="photo-preview mb-3">
                <div style="display: flex; align-items: center; gap: 12px; justify-content: center;">
                    <i class="bi bi-file-earmark-text" style="font-size: 40px; color: var(--primary);"></i>
                    <div style="text-align: left;">
                        <div style="font-weight: 700; font-size: 13px;">
                            {{ basename($surat->file_path) }}
                        </div>
                        <a href="{{ asset('storage/' . $surat->file_path) }}"
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
            accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
        >
        <div class="form-text">Format PDF, DOC, DOCX, JPG, PNG. Maksimal 5 MB.</div>
        @error('file')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="keterangan" class="form-label">Keterangan</label>
        <textarea
            id="keterangan"
            name="keterangan"
            rows="4"
            class="form-control @error('keterangan') is-invalid @enderror"
            placeholder="Catatan tambahan tentang surat ini..."
        >{{ old('keterangan', $surat->keterangan ?? '') }}</textarea>
        @error('keterangan')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.surat.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($surat) ? 'Simpan Perubahan' : 'Simpan Surat' }}
    </button>
</div>