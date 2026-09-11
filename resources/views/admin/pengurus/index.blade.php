@extends('layouts.admin')

@section('title', 'Pengurus')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Pengurus</h1>
    <p>Kelola struktur pengurus HIMAPRO TI SAKTI.</p>
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
                <h2 class="admin-card-title">Data Pengurus</h2>
                <p class="card-subtitle">Total {{ $penguruses->total() }} pengurus terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('pengurus.create'))
                <a href="{{ route('admin.pengurus.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Pengurus
                </a>
            @endif
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
                        placeholder="Cari nama atau jabatan..."
                    >
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Departemen</label>
                    <select name="departemen_id" class="form-select">
                        <option value="">Semua Departemen</option>
                        @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->id }}" @selected(request('departemen_id') == $departemen->id)>
                                {{ $departemen->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="active" @selected(request('status') === 'active')>Aktif</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'departemen_id', 'status']))
                        <a href="{{ route('admin.pengurus.index') }}" class="btn-icon" title="Reset">
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
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Departemen</th>
                        <th>Periode</th>
                        <th>Status</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penguruses as $pengurus)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $penguruses->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($pengurus->foto)
                                        <img src="{{ asset('storage/' . $pengurus->foto) }}"
                                             alt="{{ $pengurus->nama }}"
                                             class="avatar-photo">
                                    @else
                                        <span class="avatar-initials">
                                            {{ strtoupper(substr($pengurus->nama, 0, 1)) }}
                                        </span>
                                    @endif

                                    <div>
                                        <div style="font-weight: 700; font-size: 13px;">
                                            {{ $pengurus->nama }}
                                        </div>
                                        @if ($pengurus->email)
                                            <div style="font-size: 11px; color: var(--muted);">
                                                {{ $pengurus->email }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td style="font-size: 12.5px;">
                                {{ $pengurus->jabatan }}
                            </td>

                            <td>
                                @if ($pengurus->departemen)
                                    <span class="badge-himapro badge-yellow">
                                        {{ $pengurus->departemen->nama }}
                                    </span>
                                @else
                                    <span style="color: var(--muted); font-size: 12px;">—</span>
                                @endif
                            </td>

                            <td style="font-size: 12.5px; color: var(--muted);">
                                {{ $pengurus->periode }}
                            </td>

                            <td>
                                @if ($pengurus->status === 'active')
                                    <span class="badge-himapro badge-active">Aktif</span>
                                @else
                                    <span class="badge-himapro badge-inactive">Non-Aktif</span>
                                @endif
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.pengurus.show', $pengurus) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('pengurus.update'))
                                        <a href="{{ route('admin.pengurus.edit', $pengurus) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('pengurus.delete'))
                                        <form action="{{ route('admin.pengurus.destroy', $pengurus) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus pengurus ini?')">
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
                            <td colspan="7" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada data pengurus</h6>
                                <p class="mb-3">Silakan tambahkan pengurus pertama.</p>

                                @if (auth()->user()->hasPermission('pengurus.create'))
                                    <a href="{{ route('admin.pengurus.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Pengurus
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($penguruses->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $penguruses->links() }}
        </div>
    @endif

</div>

@endsection