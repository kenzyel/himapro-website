@extends('layouts.admin')

@section('title', $role->name)

@section('content')

<a href="{{ route('admin.roles.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Role
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $role->name }}</h1>
        <p>{{ $role->description ?: 'Detail role dan permission-nya.' }}</p>
    </div>

    <a href="{{ route('admin.roles.edit', $role) }}" class="btn-himapro btn-himapro-primary">
        <i class="bi bi-pencil"></i>
        Edit Role
    </a>
</div>


<div class="row g-4">

    <div class="col-lg-4">
        <div class="admin-card" data-aos="fade-up">
            <div class="card-header">
                <h2 class="admin-card-title">Informasi Role</h2>
            </div>
            <div class="card-body">

                <div class="info-block">
                    <div class="info-block-label">Nama</div>
                    <div class="info-block-value">{{ $role->name }}</div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Slug</div>
                    <div class="info-block-value" style="font-weight: 500; color: var(--muted);">
                        <code>{{ $role->slug }}</code>
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">Status</div>
                    <div>
                        @if ($role->is_active)
                            <span class="badge-himapro badge-active">Aktif</span>
                        @else
                            <span class="badge-himapro badge-inactive">Non-Aktif</span>
                        @endif
                    </div>
                </div>

                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Jumlah User</div>
                    <div class="info-block-value" style="color: var(--primary); font-size: 22px;">
                        {{ $role->users->count() }}
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div class="col-lg-8">
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header">
                <h2 class="admin-card-title">Permission ({{ $role->permissions->count() }})</h2>
                <p class="card-subtitle">Daftar permission yang dimiliki role ini</p>
            </div>
            <div class="card-body">

                @if ($role->permissions->count() > 0)
                    @php
                        $grouped = $role->permissions->groupBy('module');
                    @endphp

                    <div style="display: grid; gap: 18px;">
                        @foreach ($grouped as $module => $items)
                            <div>
                                <div class="info-block-label" style="margin-bottom: 10px;">
                                    {{ strtoupper(str_replace('-', ' ', $module)) }}
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach ($items as $permission)
                                        <span class="badge-himapro badge-yellow" style="text-transform: none;">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--muted); margin: 0;">Role ini belum memiliki permission.</p>
                @endif

            </div>
        </div>
    </div>

</div>


{{-- TOMBOL --}}
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.roles.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if ($role->users->count() === 0)
        <form action="{{ route('admin.roles.destroy', $role) }}"
              method="POST"
              onsubmit="return confirm('Yakin ingin menghapus role ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-himapro btn-himapro-danger">
                <i class="bi bi-trash"></i>
                Hapus
            </button>
        </form>
    @endif
</div>

@endsection