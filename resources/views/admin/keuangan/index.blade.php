@extends('layouts.admin')

@section('title', 'Keuangan')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Keuangan</h1>
    <p>Kelola transaksi pemasukan dan pengeluaran HIMAPRO TI SAKTI.</p>
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


{{-- STATISTIK KEUANGAN --}}
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Pemasukan</span>
                <span class="stat-icon" style="background: rgba(34,197,94,.1); color: #86efac; border-color: rgba(34,197,94,.2);">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="font-size: 20px; color: #86efac;">
                Rp {{ number_format($stats['pemasukan'], 0, ',', '.') }}
            </div>
            <div class="stat-description">Transaksi disetujui</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Pengeluaran</span>
                <span class="stat-icon" style="background: rgba(239,68,68,.1); color: #fca5a5; border-color: rgba(239,68,68,.2);">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="font-size: 20px; color: #fca5a5;">
                Rp {{ number_format($stats['pengeluaran'], 0, ',', '.') }}
            </div>
            <div class="stat-description">Transaksi disetujui</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Saldo</span>
                <span class="stat-icon"><i class="bi bi-wallet2"></i></span>
            </div>
            <div class="stat-value" style="font-size: 20px; color: var(--primary);">
                Rp {{ number_format($stats['saldo'], 0, ',', '.') }}
            </div>
            <div class="stat-description">Pemasukan - Pengeluaran</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Pending</span>
                <span class="stat-icon"><i class="bi bi-hourglass-split"></i></span>
            </div>
            <div class="stat-value" style="color: #fbbf24;">{{ $stats['pending'] }}</div>
            <div class="stat-description">Perlu ditinjau</div>
        </div>
    </div>
</div>


<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="admin-card-title">Daftar Transaksi</h2>
                <p class="card-subtitle">Total {{ $keuangans->total() }} transaksi</p>
            </div>

            @if (auth()->user()->hasPermission('keuangan.create'))
                <a href="{{ route('admin.keuangan.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Transaksi
                </a>
            @endif
        </div>
    </div>


    {{-- FILTER --}}
    <div class="px-4 pt-4">
        <form method="GET" class="filter-card">
            <div class="row g-2">

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari deskripsi..."
                    >
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-select">
                        <option value="">Semua</option>
                        <option value="pemasukan" @selected(request('jenis') === 'pemasukan')>Pemasukan</option>
                        <option value="pengeluaran" @selected(request('jenis') === 'pengeluaran')>Pengeluaran</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="approved" @selected(request('status') === 'approved')>Disetujui</option>
                        <option value="rejected" @selected(request('status') === 'rejected')>Ditolak</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Departemen</label>
                    <select name="departemen_id" class="form-select">
                        <option value="">Semua</option>
                        @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->id }}" @selected(request('departemen_id') == $departemen->id)>
                                {{ $departemen->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-lg-1 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                    </button>

                    @if(request()->hasAny(['search', 'jenis', 'status', 'departemen_id', 'from', 'to']))
                        <a href="{{ route('admin.keuangan.index') }}" class="btn-icon" title="Reset">
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
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($keuangans as $index => $keuangan)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $keuangans->firstItem() + $index }}
                            </td>

                            <td style="font-size: 12.5px;">
                                {{ $keuangan->tanggal?->format('d M Y') }}
                            </td>

                            <td>
                                <div style="font-weight: 700; font-size: 13px;">
                                    {{ $keuangan->deskripsi }}
                                </div>
                                @if ($keuangan->departemen || $keuangan->programKerja)
                                    <div style="font-size: 11px; color: var(--muted); margin-top: 3px;">
                                        {{ $keuangan->departemen?->nama }}
                                        @if ($keuangan->departemen && $keuangan->programKerja)
                                            ·
                                        @endif
                                        {{ $keuangan->programKerja?->nama }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                <span class="badge-himapro badge-yellow">
                                    {{ ucfirst(str_replace('_', ' ', $keuangan->kategori)) }}
                                </span>
                            </td>

                            <td>
                                @if ($keuangan->jenis === 'pemasukan')
                                    <span class="badge-himapro" style="background: rgba(34,197,94,.12); color: #86efac; border-color: rgba(34,197,94,.25);">
                                        <i class="bi bi-arrow-down"></i> Masuk
                                    </span>
                                @else
                                    <span class="badge-himapro" style="background: rgba(239,68,68,.12); color: #fca5a5; border-color: rgba(239,68,68,.25);">
                                        <i class="bi bi-arrow-up"></i> Keluar
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div style="font-weight: 800; font-size: 13px; color: {{ $keuangan->jenis === 'pemasukan' ? '#86efac' : '#fca5a5' }};">
                                    {{ $keuangan->jenis === 'pemasukan' ? '+' : '-' }}
                                    Rp {{ number_format($keuangan->jumlah, 0, ',', '.') }}
                                </div>
                            </td>

                            <td>
                                @switch($keuangan->status)
                                    @case('pending')
                                        <span class="badge-himapro" style="background: rgba(251,191,36,.12); color: #fbbf24; border-color: rgba(251,191,36,.25);">
                                            Pending
                                        </span>
                                        @break
                                    @case('approved')
                                        <span class="badge-himapro badge-active">Disetujui</span>
                                        @break
                                    @case('rejected')
                                        <span class="badge-himapro badge-inactive">Ditolak</span>
                                        @break
                                @endswitch
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.keuangan.show', $keuangan) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('keuangan.update'))
                                        <a href="{{ route('admin.keuangan.edit', $keuangan) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('keuangan.delete'))
                                        <form action="{{ route('admin.keuangan.destroy', $keuangan) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
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
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada transaksi</h6>
                                <p class="mb-3">Tambahkan transaksi keuangan pertama.</p>

                                @if (auth()->user()->hasPermission('keuangan.create'))
                                    <a href="{{ route('admin.keuangan.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Transaksi
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($keuangans->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $keuangans->links() }}
        </div>
    @endif

</div>

@endsection