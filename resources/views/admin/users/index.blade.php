@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Manajemen User</h1>
    <p>Kelola akun pengguna sistem HIMAPRO TI SAKTI.</p>
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
                <h2 class="admin-card-title">Daftar User</h2>
                <p class="card-subtitle">Total {{ $users->total() }} user terdaftar</p>
            </div>

            <a href="{{ route('admin.users.create') }}" class="btn-himapro btn-himapro-primary">
                <i class="bi bi-plus-lg"></i>
                Tambah User
            </a>
        </div>
    </div>


    {{-- FILTER --}}
    <div class="px-4 pt-4">
        <form method="GET" class="filter-card">
            <div class="row g-2">

                <div class="col-lg-5 col-md-6">
                    <label class="form-label">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau email..."
                    >
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Role</label>
                    <select name="role_id" class="form-select">
                        <option value="">Semua Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" @selected(request('role_id') == $role->id)>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="active" @selected(request('status') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Non-Aktif</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'role_id', 'status']))
                        <a href="{{ route('admin.users.index') }}" class="btn-icon" title="Reset">
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
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th class="text-end px-4" width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $index => $user)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $users->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}"
                                             alt="{{ $user->name }}"
                                             class="avatar-photo">
                                    @else
                                        <span class="avatar-initials">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </span>
                                    @endif

                                    <div>
                                        <div style="font-weight: 700; font-size: 13px;">
                                            {{ $user->name }}

                                            @if ($user->id === auth()->id())
                                                <span class="badge-himapro badge-yellow" style="font-size: 9px; padding: 2px 6px; margin-left: 4px;">
                                                    Anda
                                                </span>
                                            @endif
                                        </div>
                                        <div style="font-size: 11px; color: var(--muted);">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge-himapro badge-yellow">
                                    {{ $user->role?->name ?? 'Tanpa Role' }}
                                </span>
                            </td>

                            <td>
                                @if ($user->status === 'active')
                                    <span class="badge-himapro badge-active">Aktif</span>
                                @else
                                    <span class="badge-himapro badge-inactive">Non-Aktif</span>
                                @endif
                            </td>

                            <td style="font-size: 12px; color: var(--muted);">
                                {{ $user->created_at?->format('d M Y') }}
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.users.show', $user) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="btn-icon"
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada user</h6>
                                <p class="mb-3">Tambahkan user pertama sistem.</p>

                                <a href="{{ route('admin.users.create') }}" class="btn-himapro btn-himapro-primary">
                                    <i class="bi bi-plus-lg"></i>
                                    Tambah User
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($users->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $users->links() }}
        </div>
    @endif

</div>

@endsection