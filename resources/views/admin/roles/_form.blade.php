<div class="row g-4">

    {{-- SECTION: INFORMASI ROLE --}}
    <div class="col-12">
        <div class="form-section-title">Informasi Role</div>
    </div>

    <div class="col-md-6">
        <label for="name" class="form-label">Nama Role <span style="color: var(--primary);">*</span></label>
        <input
            type="text"
            id="name"
            name="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $role->name ?? '') }}"
            placeholder="Contoh: Editor Konten"
            required
        >
        @error('name')
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
            value="{{ old('slug', $role->slug ?? '') }}"
            placeholder="Otomatis dari nama"
        >
        @error('slug')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-2">
        <label for="is_active" class="form-label">Status <span style="color: var(--primary);">*</span></label>
        <select id="is_active" name="is_active" class="form-select" required>
            <option value="1" @selected(old('is_active', $role->is_active ?? true))>Aktif</option>
            <option value="0" @selected(!old('is_active', $role->is_active ?? true))>Non-Aktif</option>
        </select>
    </div>

    <div class="col-12">
        <label for="description" class="form-label">Deskripsi</label>
        <textarea
            id="description"
            name="description"
            rows="3"
            class="form-control"
            placeholder="Deskripsi singkat role ini..."
        >{{ old('description', $role->description ?? '') }}</textarea>
    </div>


    {{-- SECTION: PERMISSIONS --}}
    <div class="col-12">
        <div class="form-section-title">Permission</div>
    </div>

    <div class="col-12">
        @php
            $grouped = $permissions->groupBy('module');
            $selectedPermissions = old('permissions', isset($role) ? $role->permissions->pluck('id')->toArray() : []);
        @endphp

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
            @foreach ($grouped as $module => $items)
                <div class="permission-group">
                    <div class="permission-group-title">
                        <i class="bi bi-folder-fill"></i>
                        {{ strtoupper(str_replace('-', ' ', $module)) }}
                    </div>

                    @foreach ($items as $permission)
                        <label class="permission-item">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                @checked(in_array($permission->id, $selectedPermissions))
                            >
                            <span>{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

</div>


{{-- ACTION BUTTONS --}}
<div class="d-flex justify-content-end gap-2 mt-4 pt-4" style="border-top: 1px solid var(--border);">
    <a href="{{ route('admin.roles.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-x-lg"></i>
        Batal
    </a>

    <button type="submit" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-check-lg"></i>
        {{ isset($role) ? 'Simpan Perubahan' : 'Simpan Role' }}
    </button>
</div>