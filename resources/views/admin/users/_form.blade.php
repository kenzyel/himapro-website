<div class="row g-4">

    {{-- SECTION: IDENTITAS --}}
    <div class="col-12">
        <div class="form-section-title">Identitas</div>
    </div>

    <div class="col-md-8">
        <label for="name" class="form-label">Nama Lengkap <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="name"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $user->name ?? '') }}"
            placeholder="Contoh: Administrator HIMAPRO"
            required
        >
        @error('name')
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
            <option value="active" @selected(old('status', $user->status ?? 'active') === 'active')>
                Aktif
            </option>
            <option value="inactive" @selected(old('status', $user->status ?? '') === 'inactive')>
                Non-Aktif
            </option>
        </select>
        @error('status')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-8">
        <label for="email" class="form-label">Email <span style="color: var(--primary);">*</span></label>
        <input
            type="email"
            id="email"
            name="email"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $user->email ?? '') }}"
            placeholder="nama@email.com"
            required
        >
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="role_id" class="form-label">Role <span style="color: var(--primary);">*</span></label>
        <select
            id="role_id"
            name="role_id"
            class="form-select @error('role_id') is-invalid @enderror"
            required
        >
            <option value="">— Pilih Role —</option>
            @foreach ($roles as $role)
                <option value="{{ $role->id }}" @selected(old('role_id', $user->role_id ?? '') == $role->id)>
                    {{ $role->name }}
                </option>
            @endforeach
        </select>
        @error('role_id')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>


    {{-- SECTION: KEAMANAN --}}
    <div class="col-12">
        <div class="form-section-title">Keamanan</div>
    </div>

    <div class="col-md-6">
        <label for="password" class="form-label">
            Password
            @if ($isEdit)
                <span style="color: var(--muted); font-weight: 500;">(kosongkan jika tidak diubah)</span>
            @else
                <span style="color: var(--primary);">*</span>
            @endif
        </label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            autocomplete="new-password"
            {{ $isEdit ? '' : 'required' }}
        >
        <div class="form-text">Minimal 8 karakter.</div>
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label for="password_confirmation" class="form-label">
            Konfirmasi Password
        </label>
        <input
            type="password"
            id="password_confirmation"
            name="password_confirmation"
            class="form-control"
            autocomplete="new-password"
            {{ $isEdit ? '' : 'required' }}
        >
    </div>


    {{-- SECTION: AVATAR --}}
    <div class="col-12">
        <div class="form-section-title">Avatar</div>
    </div>

    <div class="col-md-6">
        <label for="avatar" class="form-label">Upload Avatar</label>

        @if (isset($user) && $user->avatar)
            <div class="photo-preview mb-3">
                <img src="{{ asset('storage/' . $user->avatar) }}"
                     alt="{{ $user->name }}"
                     style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
                <div class="mt-2" style="font-size: 11px; color: var(--muted);">
                    Avatar saat ini. Pilih file baru untuk mengganti.
                </div>
            </div>
        @endif

        <input
            type="file"
            id="avatar"
            name="avatar"
            class="form-control @error('avatar') is-invalid @enderror"
            accept=".jpg,.jpeg,.png,.webp"
        >
        <div class="form-text">Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.</div>
        @error('avatar')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.users.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ $isEdit ? 'Simpan Perubahan' : 'Simpan User' }}
    </button>
</div>