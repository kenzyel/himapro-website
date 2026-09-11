@extends('layouts.admin')

@section('title', 'Manajemen Role')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Manajemen Role</h1>
    <p>Kelola role dan akses permission sistem.</p>
</div>


@if (session('success'))
    <div class="alert alert-success alert-dismissible" data-aos="fade-down">
        <i class="bi bi-check-circle-fill"></i>
        <div>{{ session('success') }}</div>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible" data-aos="fade-down">
        <i class="bi bi-exclamation-circle-fill"></i>
        <div>{{ session('error') }}</div>
    </div>
@endif


<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="admin-card-title">Daftar Role</h2>
                <p class="card-subtitle">Total {{ $roles->total() }} role terdaftar</p>
            </div>

            <a href="{{ route('admin.roles.create') }}" class="btn-himapro btn-himapro-primary">
                <i class="bi bi-plus-lg"></i>
                Tambah Role
            </a>
        </div>
    </div>


    {{-- FILTER --}}
    <div class="px-4 pt-4">
        <form method="GET" class="filter-card">
            <div class="row g-2">

                <div class="col-lg-10 col-md-8">
                    <label class="form-label">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau slug role..."
                    >
                </div>

                <div class="col-lg-2 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.roles.index') }}" class="btn-icon" title="Reset">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>

            </div>
        </form>
    </div>


    {{-- TABLE --}}
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="px-4" width="60">#</th>
                        <th>Role</th>
                        <th>Slug</th>
                        <th>User</th>
                        <th>Permission</th>
                        <th>Status</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $index => $role)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $roles->firstItem() + $index }}
                            </td>

                            <td>
                                <div style="font-weight: 700; font-size: 13px;">
                                    {{ $role->name }}
                                </div>
                                @if ($role->description)
                                    <div style="font-size: 11px; color: var(--muted); margin-top: 2px; max-width: 400px;">
                                        {{ \Illuminate\Support\Str::limit($role->description, 80) }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                <code style="font-size: 11px; color: var(--muted);">
                                    {{ $role->slug }}
                                </code>
                            </td>

                            <td>
                                <span class="badge-himapro badge-yellow">
                                    <i class="bi bi-people"></i>
                                    {{ $role->users_count }}
                                </span>
                            </td>

                            <td>
                                <span class="badge-himapro badge-yellow">
                                    <i class="bi bi-key"></i>
                                    {{ $role->permissions_count }}
                                </span>
                            </td>

                            <td>
                                @if ($role->is_active)
                                    <span class="badge-himapro badge-active">Aktif</span>
                                @else
                                    <span class="badge-himapro badge-inactive">Non-Aktif</span>
                                @endif
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.roles.show', $role) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.roles.edit', $role) }}"
                                       class="btn-icon"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('admin.roles.destroy', $role) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus role ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada role</h6>
                                <p class="mb-3">Tambahkan role pertama sistem.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($roles->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $roles->links() }}
        </div>
    @endif

</div>

@endsection