<div class="row g-4">

    {{-- SECTION: INFORMASI AGENDA --}}
    <div class="col-12">
        <div class="form-section-title">Informasi Agenda</div>
    </div>

    <div class="col-12">
        <label for="judul" class="form-label">Judul Agenda <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="judul"
            name="judul"
            class="form-control @error('judul') is-invalid @enderror"
            value="{{ old('judul', $agenda->judul ?? '') }}"
            placeholder="Contoh: Rapat Kerja HIMAPRO 2026"
            required
        >
        @error('judul')
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
            placeholder="Jelaskan agenda atau kegiatan..."
        >{{ old('deskripsi', $agenda->deskripsi ?? '') }}</textarea>
        @error('deskripsi')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="lokasi" class="form-label">Lokasi</label>
        <input
            type="text"
            id="lokasi"
            name="lokasi"
            class="form-control @error('lokasi') is-invalid @enderror"
            value="{{ old('lokasi', $agenda->lokasi ?? '') }}"
            placeholder="Contoh: Ruang Seminar Kampus"
        >
        @error('lokasi')
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
            <option value="">— Tanpa Program Kerja —</option>
            @foreach ($programKerjas as $programKerja)
                <option value="{{ $programKerja->id }}"
                    @selected(old('program_kerja_id', $agenda->program_kerja_id ?? '') == $programKerja->id)>
                    {{ $programKerja->nama }}
                </option>
            @endforeach
        </select>
        @error('program_kerja_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: WAKTU --}}
    <div class="col-12">
        <div class="form-section-title">Waktu & Status</div>
    </div>

    <div class="col-md-6">
        <label for="tanggal_mulai" class="form-label">Tanggal & Waktu Mulai <span style="color: var(--primary);">*</span></label>
        <input
            type="datetime-local"
            id="tanggal_mulai"
            name="tanggal_mulai"
            class="form-control @error('tanggal_mulai') is-invalid @enderror"
            value="{{ old('tanggal_mulai', isset($agenda->tanggal_mulai) ? $agenda->tanggal_mulai->format('Y-m-d\TH:i') : '') }}"
            required
        >
        @error('tanggal_mulai')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="tanggal_selesai" class="form-label">Tanggal & Waktu Selesai</label>
        <input
            type="datetime-local"
            id="tanggal_selesai"
            name="tanggal_selesai"
            class="form-control @error('tanggal_selesai') is-invalid @enderror"
            value="{{ old('tanggal_selesai', isset($agenda->tanggal_selesai) ? $agenda->tanggal_selesai->format('Y-m-d\TH:i') : '') }}"
        >
        @error('tanggal_selesai')
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
            <option value="planned" @selected(old('status', $agenda->status ?? 'planned') === 'planned')>
                Direncanakan
            </option>
            <option value="ongoing" @selected(old('status', $agenda->status ?? '') === 'ongoing')>
                Berlangsung
            </option>
            <option value="completed" @selected(old('status', $agenda->status ?? '') === 'completed')>
                Selesai
            </option>
            <option value="cancelled" @selected(old('status', $agenda->status ?? '') === 'cancelled')>
                Dibatalkan
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
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
                @checked(old('is_public', isset($agenda) ? $agenda->is_public : true))
            >
            <label class="form-check-label" for="is_public" style="font-size: 13px;">
                Tampilkan sebagai agenda publik
            </label>
        </div>

        @error('is_public')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.agenda.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($agenda) ? 'Simpan Perubahan' : 'Simpan Agenda' }}
    </button>
</div>