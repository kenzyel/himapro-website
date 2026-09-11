@extends('layouts.admin')

@section('title', 'Notulensi')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Notulensi</h1>
    <p>Kelola catatan rapat dan notulensi HIMAPRO TI SAKTI.</p>
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
                <span class="stat-label">Total Notulensi</span>
                <span class="stat-icon"><i class="bi bi-journal-text"></i></span>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-description">Semua catatan</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Draft</span>
                <span class="stat-icon"><i class="bi bi-pencil-square"></i></span>
            </div>
            <div class="stat-value" style="color: var(--primary);">{{ $stats['draft'] }}</div>
            <div class="stat-description">Belum final</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Final</span>
                <span class="stat-icon"><i class="bi bi-check2-circle"></i></span>
            </div>
            <div class="stat-value" style="color: #86efac;">{{ $stats['final'] }}</div>
            <div class="stat-description">Sudah final</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Diarsipkan</span>
                <span class="stat-icon"><i class="bi bi-archive-fill"></i></span>
            </div>
            <div class="stat-value" style="color: var(--muted);">{{ $stats['archived'] }}</div>
            <div class="stat-description">Arsip</div>
        </div>
    </div>
</div>


<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="admin-card-title">Daftar Notulensi</h2>
                <p class="card-subtitle">Total {{ $notulensis->total() }} notulensi terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('notulensi.create'))
                <a href="{{ route('admin.notulensi.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Notulensi
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
                        placeholder="Cari judul, tempat, agenda..."
                    >
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                        <option value="final" @selected(request('status') === 'final')>Final</option>
                        <option value="archived" @selected(request('status') === 'archived')>Diarsipkan</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="to" class="form-control" value="{{ request('to') }}">
                </div>

                <div class="col-lg-2 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'status', 'from', 'to']))
                        <a href="{{ route('admin.notulensi.index') }}" class="btn-icon" title="Reset">
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
                        <th>Notulensi</th>
                        <th>Tanggal</th>
                        <th>Tempat</th>
                        <th>File</th>
                        <th>Status</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notulensis as $index => $notulensi)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $notulensis->firstItem() + $index }}
                            </td>

                            <td>
                                <div style="font-weight: 700; font-size: 13px;">
                                    {{ $notulensi->judul }}
                                </div>
                                @if ($notulensi->agenda)
                                    <div style="font-size: 11px; color: var(--muted); margin-top: 3px; max-width: 400px;">
                                        {{ \Illuminate\Support\Str::limit($notulensi->agenda, 80) }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                <div style="font-size: 12.5px;">
                                    {{ $notulensi->tanggal?->format('d M Y') }}
                                </div>
                                <div style="font-size: 10.5px; color: var(--muted);">
                                    {{ $notulensi->tanggal?->format('H:i') }}
                                </div>
                            </td>

                            <td style="font-size: 12.5px; color: var(--muted);">
                                {{ $notulensi->tempat ?: '—' }}
                            </td>

                            <td>
                                @if ($notulensi->file_path)
                                    <a href="{{ asset('storage/' . $notulensi->file_path) }}"
                                       target="_blank"
                                       class="btn-icon"
                                       title="Unduh file">
                                        <i class="bi bi-file-earmark-arrow-down"></i>
                                    </a>
                                @else
                                    <span style="color: var(--muted); font-size: 11.5px;">—</span>
                                @endif
                            </td>

                            <td>
                                @switch($notulensi->status)
                                    @case('draft')
                                        <span class="badge-himapro badge-yellow">Draft</span>
                                        @break
                                    @case('final')
                                        <span class="badge-himapro badge-active">Final</span>
                                        @break
                                    @case('archived')
                                        <span class="badge-himapro" style="background: rgba(255,255,255,.05); color: var(--muted); border-color: var(--border);">
                                            Diarsipkan
                                        </span>
                                        @break
                                @endswitch
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.notulensi.show', $notulensi) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('notulensi.update'))
                                        <a href="{{ route('admin.notulensi.edit', $notulensi) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('notulensi.delete'))
                                        <form action="{{ route('admin.notulensi.destroy', $notulensi) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus notulensi ini?')">
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
                                    <i class="bi bi-journal-text"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada notulensi</h6>
                                <p class="mb-3">Tambahkan catatan rapat pertama HIMAPRO TI SAKTI.</p>

                                @if (auth()->user()->hasPermission('notulensi.create'))
                                    <a href="{{ route('admin.notulensi.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Notulensi
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($notulensis->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $notulensis->links() }}
        </div>
    @endif

</div>

@endsection