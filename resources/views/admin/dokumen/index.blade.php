@extends('layouts.admin')

@section('title', 'Dokumen')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Dokumen</h1>
    <p>Kelola arsip dokumen HIMAPRO TI SAKTI.</p>
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
                <span class="stat-label">Total Dokumen</span>
                <span class="stat-icon"><i class="bi bi-folder-fill"></i></span>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-description">Semua file</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Publik</span>
                <span class="stat-icon"><i class="bi bi-globe"></i></span>
            </div>
            <div class="stat-value" style="color: #86efac;">{{ $stats['public'] }}</div>
            <div class="stat-description">Tampil di website</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Internal</span>
                <span class="stat-icon"><i class="bi bi-lock-fill"></i></span>
            </div>
            <div class="stat-value" style="color: var(--primary);">{{ $stats['private'] }}</div>
            <div class="stat-description">Hanya pengurus</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Ukuran</span>
                <span class="stat-icon"><i class="bi bi-hdd-fill"></i></span>
            </div>
            <div class="stat-value" style="font-size: 22px;">
                {{ number_format($stats['total_size'] / 1024 / 1024, 1) }} MB
            </div>
            <div class="stat-description">Penyimpanan terpakai</div>
        </div>
    </div>
</div>


<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="admin-card-title">Daftar Dokumen</h2>
                <p class="card-subtitle">Total {{ $dokumens->total() }} dokumen terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('dokumen.create'))
                <a href="{{ route('admin.dokumen.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-cloud-upload"></i>
                    Upload Dokumen
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
                        placeholder="Cari nama dokumen..."
                    >
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Kategori</label>
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach ($kategoris as $key => $label)
                            <option value="{{ $key }}" @selected(request('kategori') === $key)>
                                {{ $label }}
                            </option>
                        @endforeach
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

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Publikasi</label>
                    <select name="is_public" class="form-select">
                        <option value="">Semua</option>
                        <option value="1" @selected(request('is_public') === '1')>Publik</option>
                        <option value="0" @selected(request('is_public') === '0')>Internal</option>
                    </select>
                </div>

                <div class="col-lg-1 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                    </button>

                    @if(request()->hasAny(['search', 'kategori', 'periode', 'is_public']))
                        <a href="{{ route('admin.dokumen.index') }}" class="btn-icon" title="Reset">
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
                        <th>Dokumen</th>
                        <th>Kategori</th>
                        <th>Ukuran</th>
                        <th>Periode</th>
                        <th>Publikasi</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dokumens as $index => $dokumen)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $dokumens->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div style="
                                        width: 42px;
                                        height: 42px;
                                        display: flex;
                                        align-items: center;
                                        justify-content: center;
                                        border-radius: 10px;
                                        background: rgba(255,210,26,.1);
                                        border: 1px solid rgba(255,210,26,.2);
                                        color: var(--primary);
                                        font-size: 18px;
                                        flex-shrink: 0;
                                    ">
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                    </div>

                                    <div>
                                        <div style="font-weight: 700; font-size: 13px;">
                                            {{ $dokumen->nama }}
                                        </div>
                                        <div style="font-size: 11px; color: var(--muted);">
                                            {{ $dokumen->file_name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge-himapro badge-yellow">
                                    {{ $kategoris[$dokumen->kategori] ?? $dokumen->kategori }}
                                </span>
                            </td>

                            <td style="font-size: 12px; color: var(--muted);">
                                @if ($dokumen->file_size)
                                    {{ number_format($dokumen->file_size / 1024, 0) }} KB
                                @else
                                    —
                                @endif
                            </td>

                            <td style="font-size: 12.5px;">
                                {{ $dokumen->periode ?: '—' }}
                            </td>

                            <td>
                                @if ($dokumen->is_public)
                                    <span class="badge-himapro badge-active">
                                        <i class="bi bi-globe"></i> Publik
                                    </span>
                                @else
                                    <span class="badge-himapro badge-inactive">
                                        <i class="bi bi-lock"></i> Internal
                                    </span>
                                @endif
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.dokumen.show', $dokumen) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('dokumen.update'))
                                        <a href="{{ route('admin.dokumen.edit', $dokumen) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('dokumen.delete'))
                                        <form action="{{ route('admin.dokumen.destroy', $dokumen) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
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
                                    <i class="bi bi-folder"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada dokumen</h6>
                                <p class="mb-3">Upload dokumen pertama HIMAPRO TI SAKTI.</p>

                                @if (auth()->user()->hasPermission('dokumen.create'))
                                    <a href="{{ route('admin.dokumen.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-cloud-upload"></i>
                                        Upload Dokumen
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($dokumens->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $dokumens->links() }}
        </div>
    @endif

</div>

@endsection