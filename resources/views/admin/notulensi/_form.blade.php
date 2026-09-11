<div class="row g-4">

    {{-- SECTION: INFORMASI RAPAT --}}
    <div class="col-12">
        <div class="form-section-title">Informasi Rapat</div>
    </div>

    <div class="col-12">
        <label for="judul" class="form-label">Judul Notulensi <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="judul"
            name="judul"
            class="form-control @error('judul') is-invalid @enderror"
            value="{{ old('judul', $notulensi->judul ?? '') }}"
            placeholder="Contoh: Rapat Koordinasi Bulanan Pengurus"
            required
        >
        @error('judul')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tanggal" class="form-label">Tanggal & Waktu <span style="color: var(--primary);">*</span></label>
        <input
            type="datetime-local"
            id="tanggal"
            name="tanggal"
            class="form-control @error('tanggal') is-invalid @enderror"
            value="{{ old('tanggal', isset($notulensi->tanggal) ? $notulensi->tanggal->format('Y-m-d\TH:i') : '') }}"
            required
        >
        @error('tanggal')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tempat" class="form-label">Tempat</label>
        <input
            type="text"
            id="tempat"
            name="tempat"
            class="form-control @error('tempat') is-invalid @enderror"
            value="{{ old('tempat', $notulensi->tempat ?? '') }}"
            placeholder="Contoh: Ruang Rapat Gedung A"
        >
        @error('tempat')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="agenda" class="form-label">Agenda Rapat</label>
        <textarea
            id="agenda"
            name="agenda"
            rows="4"
            class="form-control @error('agenda') is-invalid @enderror"
            placeholder="Tuliskan agenda atau pokok bahasan rapat..."
        >{{ old('agenda', $notulensi->agenda ?? '') }}</textarea>
        @error('agenda')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="peserta" class="form-label">Peserta Rapat</label>
        <textarea
            id="peserta"
            name="peserta"
            rows="4"
            class="form-control @error('peserta') is-invalid @enderror"
            placeholder="Tuliskan nama-nama peserta rapat (satu per baris)..."
        >{{ old('peserta', $notulensi->peserta ?? '') }}</textarea>
        <div class="form-text">Pisahkan dengan enter atau koma.</div>
        @error('peserta')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: ISI --}}
    <div class="col-12">
        <div class="form-section-title">Isi Notulensi</div>
    </div>

    <div class="col-12">
        <label for="isi" class="form-label">Isi Notulensi <span style="color: var(--primary);">*</span></label>
        <textarea
            id="isi"
            name="isi"
            rows="15"
            class="form-control @error('isi') is-invalid @enderror"
            placeholder="Tulis isi notulensi secara lengkap: pembahasan, keputusan, tindak lanjut, dll."
            required
        >{{ old('isi', $notulensi->isi ?? '') }}</textarea>
        @error('isi')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: FILE & STATUS --}}
    <div class="col-12">
        <div class="form-section-title">File & Status</div>
    </div>

    <div class="col-md-8">
        <label for="file" class="form-label">File Notulensi (PDF/DOC)</label>

        @if (isset($notulensi) && $notulensi->file_path)
            <div class="photo-preview mb-3">
                <div style="display: flex; align-items: center; gap: 12px; justify-content: center;">
                    <i class="bi bi-file-earmark-text" style="font-size: 40px; color: var(--primary);"></i>
                    <div style="text-align: left;">
                        <div style="font-weight: 700; font-size: 13px;">
                            {{ basename($notulensi->file_path) }}
                        </div>
                        <a href="{{ asset('storage/' . $notulensi->file_path) }}"
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
            accept=".pdf,.doc,.docx"
        >
        <div class="form-text">Format PDF, DOC, atau DOCX. Maksimal 5 MB.</div>
        @error('file')
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
            <option value="draft" @selected(old('status', $notulensi->status ?? 'draft') === 'draft')>
                Draft
            </option>
            <option value="final" @selected(old('status', $notulensi->status ?? '') === 'final')>
                Final
            </option>
            <option value="archived" @selected(old('status', $notulensi->status ?? '') === 'archived')>
                Diarsipkan
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.notulensi.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($notulensi) ? 'Simpan Perubahan' : 'Simpan Notulensi' }}
    </button>
</div>