@extends('layouts.admin')

@section('title', 'Departemen')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Departemen</h1>
    <p>Kelola struktur departemen HIMAPRO TI SAKTI.</p>
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
                <h2 class="admin-card-title">Daftar Departemen</h2>
                <p class="card-subtitle">Total {{ $departemens->total() }} departemen terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('departemen.create'))
                <a href="{{ route('admin.departemen.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Departemen
                </a>
            @endif
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
                        value="{{ $search }}"
                        placeholder="Cari nama, kode, atau deskripsi departemen..."
                    >
                </div>

                <div class="col-lg-2 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if($search !== '')
                        <a href="{{ route('admin.departemen.index') }}" class="btn-icon" title="Reset">
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
                        <th>Departemen</th>
                        <th>Kode</th>
                        <th>Warna</th>
                        <th>Pengurus</th>
                        <th>Status</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departemens as $index => $departemen)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $departemens->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="
                                        width: 40px;
                                        height: 40px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        border-radius: 11px;
                                        background: {{ $departemen->warna ?: '#FFD21A' }};
                                        color: #111;
                                        font-size: 17px;
                                        box-shadow: 0 4px 14px rgba(0,0,0,.3);
                                    ">
                                        <i class="bi {{ $departemen->icon ?: 'bi-diagram-3-fill' }}"></i>
                                    </div>

                                    <div>
                                        <div style="font-weight: 700; font-size: 13px;">
                                            {{ $departemen->nama }}
                                        </div>
                                        <div style="font-size: 11px; color: var(--muted);">
                                            {{ $departemen->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge-himapro badge-yellow">
                                    {{ $departemen->kode }}
                                </span>
                            </td>

                            <td>
                                @if ($departemen->warna)
                                    <div class="d-flex align-items-center gap-2">
                                        <span style="
                                            width: 22px;
                                            height: 22px;
                                            border-radius: 6px;
                                            background: {{ $departemen->warna }};
                                            border: 1px solid rgba(255,255,255,.15);
                                        "></span>
                                        <code style="font-size: 11px; color: var(--muted);">{{ $departemen->warna }}</code>
                                    </div>
                                @else
                                    <span style="color: var(--muted);">—</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge-himapro badge-yellow">
                                    {{ $departemen->pengurus()->count() }} orang
                                </span>
                            </td>

                            <td>
                                @if ($departemen->status === 'active')
                                    <span class="badge-himapro badge-active">Aktif</span>
                                @else
                                    <span class="badge-himapro badge-inactive">Non-Aktif</span>
                                @endif
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.departemen.show', $departemen) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('departemen.update'))
                                        <a href="{{ route('admin.departemen.edit', $departemen) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('departemen.delete'))
                                        <form action="{{ route('admin.departemen.destroy', $departemen) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus departemen ini?')">
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
                                    <i class="bi bi-diagram-3"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada departemen</h6>
                                <p class="mb-3">Silakan tambahkan departemen pertama.</p>

                                @if (auth()->user()->hasPermission('departemen.create'))
                                    <a href="{{ route('admin.departemen.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Departemen
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($departemens->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $departemens->links() }}
        </div>
    @endif

</div>

@endsection