@extends('layouts.admin')

@section('title', 'Surat')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Surat</h1>
    <p>Kelola surat masuk dan keluar HIMAPRO TI SAKTI.</p>
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
                <span class="stat-label">Total Surat</span>
                <span class="stat-icon"><i class="bi bi-envelope-fill"></i></span>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-description">Semua surat</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Surat Masuk</span>
                <span class="stat-icon"><i class="bi bi-inbox-fill"></i></span>
            </div>
            <div class="stat-value" style="color: #86efac;">{{ $stats['masuk'] }}</div>
            <div class="stat-description">Diterima</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Surat Keluar</span>
                <span class="stat-icon"><i class="bi bi-send-fill"></i></span>
            </div>
            <div class="stat-value" style="color: var(--primary);">{{ $stats['keluar'] }}</div>
            <div class="stat-description">Dikirim</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Draft</span>
                <span class="stat-icon"><i class="bi bi-pencil-square"></i></span>
            </div>
            <div class="stat-value">{{ $stats['draft'] }}</div>
            <div class="stat-description">Belum diproses</div>
        </div>
    </div>
</div>


<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div>
                <h2 class="admin-card-title">Daftar Surat</h2>
                <p class="card-subtitle">Total {{ $surats->total() }} surat terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('surat.create'))
                <a href="{{ route('admin.surat.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Surat
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
                        placeholder="Cari nomor, perihal, pengirim..."
                    >
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-select">
                        <option value="">Semua</option>
                        <option value="masuk" @selected(request('jenis') === 'masuk')>Surat Masuk</option>
                        <option value="keluar" @selected(request('jenis') === 'keluar')>Surat Keluar</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                        <option value="sent" @selected(request('status') === 'sent')>Terkirim</option>
                        <option value="received" @selected(request('status') === 'received')>Diterima</option>
                        <option value="archived" @selected(request('status') === 'archived')>Diarsipkan</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="from" class="form-control" value="{{ request('from') }}">
                </div>

                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'jenis', 'status', 'from', 'to']))
                        <a href="{{ route('admin.surat.index') }}" class="btn-icon" title="Reset">
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
                        <th>Nomor & Perihal</th>
                        <th>Jenis</th>
                        <th>Pengirim / Penerima</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($surats as $index => $surat)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $surats->firstItem() + $index }}
                            </td>

                            <td>
                                <div style="font-weight: 700; font-size: 13px;">
                                    {{ $surat->nomor_surat }}
                                </div>
                                <div style="font-size: 11px; color: var(--muted); margin-top: 3px; max-width: 300px;">
                                    {{ \Illuminate\Support\Str::limit($surat->perihal, 60) }}
                                </div>
                            </td>

                            <td>
                                @if ($surat->jenis === 'masuk')
                                    <span class="badge-himapro" style="background: rgba(34,197,94,.12); color: #86efac; border-color: rgba(34,197,94,.25);">
                                        <i class="bi bi-inbox-fill"></i> Masuk
                                    </span>
                                @else
                                    <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                                        <i class="bi bi-send-fill"></i> Keluar
                                    </span>
                                @endif
                            </td>

                            <td style="font-size: 12.5px;">
                                @if ($surat->jenis === 'masuk')
                                    <span style="color: var(--muted); font-size: 10.5px;">DARI</span>
                                    <div>{{ $surat->pengirim ?: '—' }}</div>
                                @else
                                    <span style="color: var(--muted); font-size: 10.5px;">UNTUK</span>
                                    <div>{{ $surat->penerima ?: '—' }}</div>
                                @endif
                            </td>

                            <td>
                                <div style="font-size: 12px;">
                                    {{ $surat->tanggal_surat?->format('d M Y') }}
                                </div>
                                @if ($surat->tanggal_terima)
                                    <div style="font-size: 10.5px; color: var(--muted);">
                                        Terima: {{ $surat->tanggal_terima->format('d M Y') }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                @switch($surat->status)
                                    @case('draft')
                                        <span class="badge-himapro badge-yellow">Draft</span>
                                        @break
                                    @case('sent')
                                        <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                                            Terkirim
                                        </span>
                                        @break
                                    @case('received')
                                        <span class="badge-himapro badge-active">Diterima</span>
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
                                    <a href="{{ route('admin.surat.show', $surat) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('surat.update'))
                                        <a href="{{ route('admin.surat.edit', $surat) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('surat.delete'))
                                        <form action="{{ route('admin.surat.destroy', $surat) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus surat ini?')">
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
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada surat</h6>
                                <p class="mb-3">Tambahkan surat pertama HIMAPRO TI SAKTI.</p>

                                @if (auth()->user()->hasPermission('surat.create'))
                                    <a href="{{ route('admin.surat.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Surat
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($surats->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $surats->links() }}
        </div>
    @endif

</div>

@endsection