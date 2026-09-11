<div class="row g-4">

    {{-- SECTION: IDENTITAS --}}
    <div class="col-12">
        <div class="form-section-title">Identitas</div>
    </div>

    <div class="col-md-8">
        <label for="nama" class="form-label">Nama Lengkap <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="nama"
            name="nama"
            class="form-control @error('nama') is-invalid @enderror"
            value="{{ old('nama', $pengurus->nama ?? '') }}"
            placeholder="Contoh: Gilang Dwi Hermawan"
            required
        >
        @error('nama')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="jabatan" class="form-label">Jabatan <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="jabatan"
            name="jabatan"
            class="form-control @error('jabatan') is-invalid @enderror"
            value="{{ old('jabatan', $pengurus->jabatan ?? '') }}"
            placeholder="Contoh: Ketua Umum"
            required
        >
        @error('jabatan')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="tipe_jabatan" class="form-label">Tipe Jabatan <span style="color: var(--primary);">*</span></label>
        <select
            id="tipe_jabatan"
            name="tipe_jabatan"
            class="form-select @error('tipe_jabatan') is-invalid @enderror"
            required
        >
            @foreach ([
                'pembina'    => 'Pembina',
                'pimpinan'   => 'Pimpinan',
                'sekretaris' => 'Sekretaris',
                'bendahara'  => 'Bendahara',
                'co'         => 'CO Departemen',
                'agt'        => 'Anggota Departemen',
            ] as $value => $label)
                <option value="{{ $value }}" @selected(old('tipe_jabatan', $pengurus->tipe_jabatan ?? '') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
        @error('tipe_jabatan')
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
            value="{{ old('periode', $pengurus->periode ?? '2026/2027') }}"
            placeholder="2026/2027"
            required
        >
        @error('periode')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="urutan" class="form-label">Urutan <span style="color: var(--primary);">*</span></label>
        <input
            type="number"
            id="urutan"
            name="urutan"
            class="form-control @error('urutan') is-invalid @enderror"
            value="{{ old('urutan', $pengurus->urutan ?? 1) }}"
            min="1"
            required
        >
        @error('urutan')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: STRUKTUR --}}
    <div class="col-12">
        <div class="form-section-title">Struktur Organisasi</div>
    </div>

    <div class="col-md-6">
        <label for="departemen_id" class="form-label">Departemen</label>
        <select
            id="departemen_id"
            name="departemen_id"
            class="form-select @error('departemen_id') is-invalid @enderror"
        >
            <option value="">— Tidak ada / Pimpinan —</option>
            @foreach ($departemens as $departemen)
                <option value="{{ $departemen->id }}" @selected(old('departemen_id', $pengurus->departemen_id ?? '') == $departemen->id)>
                    {{ $departemen->nama }}
                </option>
            @endforeach
        </select>
        @error('departemen_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="parent_id" class="form-label">Parent / Atasan</label>
        <select
            id="parent_id"
            name="parent_id"
            class="form-select @error('parent_id') is-invalid @enderror"
        >
            <option value="">— Tidak ada —</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $pengurus->parent_id ?? '') == $parent->id)>
                    {{ $parent->nama }} — {{ $parent->jabatan }}
                </option>
            @endforeach
        </select>
        @error('parent_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: KONTAK --}}
    <div class="col-12">
        <div class="form-section-title">Kontak</div>
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $pengurus->email ?? '') }}"
            placeholder="nama@email.com"
        >
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="telepon" class="form-label">Telepon</label>
        <input
            type="text"
            id="telepon"
            name="telepon"
            class="form-control @error('telepon') is-invalid @enderror"
            value="{{ old('telepon', $pengurus->telepon ?? '') }}"
            placeholder="08xxxxxxxxxx"
        >
        @error('telepon')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: BIOGRAFI --}}
    <div class="col-12">
        <div class="form-section-title">Biografi</div>
    </div>

    <div class="col-12">
        <label for="bio" class="form-label">Bio Singkat</label>
        <textarea
            id="bio"
            name="bio"
            rows="4"
            class="form-control @error('bio') is-invalid @enderror"
            placeholder="Deskripsi singkat tentang pengurus..."
        >{{ old('bio', $pengurus->bio ?? '') }}</textarea>
        @error('bio')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: FOTO & STATUS --}}
    <div class="col-12">
        <div class="form-section-title">Foto & Status</div>
    </div>

    <div class="col-md-6">
        <label for="foto" class="form-label">Foto Profil</label>

        @if (isset($pengurus) && $pengurus->foto)
            <div class="photo-preview mb-3">
                <img src="{{ asset('storage/' . $pengurus->foto) }}" alt="{{ $pengurus->nama }}">
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">
                    Foto saat ini. Pilih file baru untuk mengganti.
                </div>
            </div>
        @endif

        <input
            type="file"
            id="foto"
            name="foto"
            class="form-control @error('foto') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp"
        >
        <div class="form-text">Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.</div>
        @error('foto')
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
            <option value="active" @selected(old('status', $pengurus->status ?? 'active') === 'active')>
                Aktif
            </option>
            <option value="inactive" @selected(old('status', $pengurus->status ?? '') === 'inactive')>
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
    <a href="{{ route('admin.pengurus.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ $buttonText ?? 'Simpan' }}
    </button>
</div>