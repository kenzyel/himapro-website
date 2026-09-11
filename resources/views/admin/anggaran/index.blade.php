@extends('layouts.admin')

@section('title', 'Anggaran')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Anggaran</h1>
    <p>Kelola perencanaan anggaran HIMAPRO TI SAKTI.</p>
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


{{-- STATISTIK --}}
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Anggaran</span>
                <span class="stat-icon"><i class="bi bi-cash-stack"></i></span>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-description">Item anggaran</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Nominal</span>
                <span class="stat-icon"><i class="bi bi-currency-dollar"></i></span>
            </div>
            <div class="stat-value" style="font-size: 20px; color: var(--primary);">
                Rp {{ number_format($stats['total_jumlah'], 0, ',', '.') }}
            </div>
            <div class="stat-description">Semua anggaran</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Disetujui</span>
                <span class="stat-icon"><i class="bi bi-check2-circle"></i></span>
            </div>
            <div class="stat-value" style="color: #86efac;">{{ $stats['approved'] }}</div>
            <div class="stat-description">Approved</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Realisasi</span>
                <span class="stat-icon"><i class="bi bi-bag-check-fill"></i></span>
            </div>
            <div class="stat-value">{{ $stats['realized'] }}</div>
            <div class="stat-description">Sudah direalisasi</div>
        </div>
    </div>
</div>


<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="admin-card-title">Daftar Anggaran</h2>
                <p class="card-subtitle">Total {{ $anggarans->total() }} item anggaran</p>
            </div>

            @if (auth()->user()->hasPermission('anggaran.create'))
                <a href="{{ route('admin.anggaran.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Anggaran
                </a>
            @endif
        </div>
    </div>


    {{-- FILTER --}}
    <div class="px-4 pt-4">
        <form method="GET" class="filter-card">
            <div class="row g-2">

                <div class="col-lg-4 col-md-6">
                    <label class="form-label">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari nama anggaran..."
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
                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                        <option value="approved" @selected(request('status') === 'approved')>Disetujui</option>
                        <option value="realized" @selected(request('status') === 'realized')>Realisasi</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Periode</label>
                    <input
                        type="text"
                        name="periode"
                        class="form-control"
                        value="{{ request('periode') }}"
                        placeholder="2026/2027"
                    >
                </div>

                <div class="col-lg-1 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                    </button>

                    @if(request()->hasAny(['search', 'departemen_id', 'status', 'periode']))
                        <a href="{{ route('admin.anggaran.index') }}" class="btn-icon" title="Reset">
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
                        <th>Nama Anggaran</th>
                        <th>Departemen</th>
                        <th>Program Kerja</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($anggarans as $index => $anggaran)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $anggarans->firstItem() + $index }}
                            </td>

                            <td>
                                <div style="font-weight: 700; font-size: 13px;">
                                    {{ $anggaran->nama }}
                                </div>
                            </td>

                            <td>
                                @if ($anggaran->departemen)
                                    <span class="badge-himapro badge-yellow">
                                        {{ $anggaran->departemen->nama }}
                                    </span>
                                @else
                                    <span style="color: var(--muted); font-size: 11.5px;">—</span>
                                @endif
                            </td>

                            <td style="font-size: 12px; color: var(--muted);">
                                {{ $anggaran->programKerja?->nama ?? '—' }}
                            </td>

                            <td style="font-size: 12.5px;">
                                {{ $anggaran->periode }}
                            </td>

                            <td>
                                <div style="font-weight: 800; font-size: 13px; color: var(--primary);">
                                    Rp {{ number_format($anggaran->jumlah, 0, ',', '.') }}
                                </div>
                            </td>

                            <td>
                                @switch($anggaran->status)
                                    @case('draft')
                                        <span class="badge-himapro badge-yellow">Draft</span>
                                        @break
                                    @case('approved')
                                        <span class="badge-himapro badge-active">Disetujui</span>
                                        @break
                                    @case('realized')
                                        <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                                            Realisasi
                                        </span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge-himapro badge-inactive">Dibatalkan</span>
                                        @break
                                @endswitch
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.anggaran.show', $anggaran) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('anggaran.update'))
                                        <a href="{{ route('admin.anggaran.edit', $anggaran) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('anggaran.delete'))
                                        <form action="{{ route('admin.anggaran.destroy', $anggaran) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus anggaran ini?')">
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
                            <td colspan="8" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada anggaran</h6>
                                <p class="mb-3">Tambahkan item anggaran pertama HIMAPRO TI SAKTI.</p>

                                @if (auth()->user()->hasPermission('anggaran.create'))
                                    <a href="{{ route('admin.anggaran.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Anggaran
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($anggarans->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $anggarans->links() }}
        </div>
    @endif

</div>

@endsection