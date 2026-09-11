<div class="row g-4">

    {{-- SECTION: ISI PENGUMUMAN --}}
    <div class="col-12">
        <div class="form-section-title">Isi Pengumuman</div>
    </div>

    <div class="col-12">
        <label for="judul" class="form-label">Judul <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="judul"
            name="judul"
            class="form-control @error('judul') is-invalid @enderror"
            value="{{ old('judul', $pengumuman->judul ?? '') }}"
            placeholder="Contoh: Pendaftaran Anggota Baru HIMAPRO"
            required
        >
        @error('judul')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="ringkasan" class="form-label">Ringkasan</label>
        <textarea
            id="ringkasan"
            name="ringkasan"
            rows="3"
            maxlength="500"
            class="form-control @error('ringkasan') is-invalid @enderror"
            placeholder="Ringkasan singkat untuk preview..."
        >{{ old('ringkasan', $pengumuman->ringkasan ?? '') }}</textarea>
        <div class="form-text">Maksimal 500 karakter.</div>
        @error('ringkasan')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-12">
        <label for="isi" class="form-label">Isi Pengumuman <span style="color: var(--primary);">*</span></label>
        <textarea
            id="isi"
            name="isi"
            rows="14"
            class="form-control @error('isi') is-invalid @enderror"
            placeholder="Tulis isi pengumuman secara lengkap..."
            required
        >{{ old('isi', $pengumuman->isi ?? '') }}</textarea>
        @error('isi')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: STATUS & PUBLIKASI --}}
    <div class="col-12">
        <div class="form-section-title">Status & Publikasi</div>
    </div>

    <div class="col-md-4">
        <label for="status" class="form-label">Status <span style="color: var(--primary);">*</span></label>
        <select
            id="status"
            name="status"
            class="form-select @error('status') is-invalid @enderror"
            required
        >
            <option value="draft" @selected(old('status', $pengumuman->status ?? 'draft') === 'draft')>
                Draft
            </option>
            <option value="published" @selected(old('status', $pengumuman->status ?? '') === 'published')>
                Published
            </option>
            <option value="archived" @selected(old('status', $pengumuman->status ?? '') === 'archived')>
                Diarsipkan
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="published_at" class="form-label">Tanggal Publikasi</label>
        <input
            type="datetime-local"
            id="published_at"
            name="published_at"
            class="form-control @error('published_at') is-invalid @enderror"
            value="{{ old('published_at', isset($pengumuman->published_at) ? $pengumuman->published_at->format('Y-m-d\TH:i') : '') }}"
        >
        @error('published_at')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="is_published" class="form-label">Publikasi</label>

        <div class="form-check form-switch" style="padding-top: 8px;">
            <input type="hidden" name="is_published" value="0">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="is_published"
                name="is_published"
                value="1"
                @checked(old('is_published', isset($pengumuman) ? $pengumuman->is_published : false))
            >
            <label class="form-check-label" for="is_published" style="font-size: 13px;">
                Tampilkan ke publik
            </label>
        </div>
        <div class="form-text">Jika aktif, pengumuman tampil di website publik.</div>

        @error('is_published')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Hidden slug --}}
    <input type="hidden" name="slug" value="{{ old('slug', $pengumuman->slug ?? '') }}">

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.pengumuman.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($pengumuman) ? 'Simpan Perubahan' : 'Simpan Pengumuman' }}
    </button>
</div>