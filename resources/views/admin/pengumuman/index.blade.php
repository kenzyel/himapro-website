@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Pengumuman</h1>
    <p>Kelola berita, informasi, dan pengumuman HIMAPRO TI SAKTI.</p>
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
                <h2 class="admin-card-title">Daftar Pengumuman</h2>
                <p class="card-subtitle">Total {{ $pengumumans->total() }} pengumuman terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('pengumuman.create'))
                <a href="{{ route('admin.pengumuman.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Pengumuman
                </a>
            @endif
        </div>
    </div>


    {{-- FILTER --}}
    <div class="px-4 pt-4">
        <form method="GET" class="filter-card">
            <div class="row g-2">

                <div class="col-lg-6 col-md-6">
                    <label class="form-label">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari judul atau isi pengumuman..."
                    >
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                        <option value="published" @selected(request('status') === 'published')>Published</option>
                        <option value="archived" @selected(request('status') === 'archived')>Diarsipkan</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Publikasi</label>
                    <select name="is_published" class="form-select">
                        <option value="">Semua</option>
                        <option value="1" @selected(request('is_published') === '1')>Publik</option>
                        <option value="0" @selected(request('is_published') === '0')>Internal</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'status', 'is_published']))
                        <a href="{{ route('admin.pengumuman.index') }}" class="btn-icon" title="Reset">
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
                        <th>Pengumuman</th>
                        <th>Status</th>
                        <th>Publikasi</th>
                        <th>Tanggal</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengumumans as $index => $pengumuman)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $pengumumans->firstItem() + $index }}
                            </td>

                            <td>
                                <div style="font-weight: 700; font-size: 13px;">
                                    {{ $pengumuman->judul }}
                                </div>
                                @if ($pengumuman->ringkasan)
                                    <div style="font-size: 11px; color: var(--muted); margin-top: 3px; max-width: 460px;">
                                        {{ \Illuminate\Support\Str::limit($pengumuman->ringkasan, 100) }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                @switch($pengumuman->status)
                                    @case('draft')
                                        <span class="badge-himapro badge-yellow">Draft</span>
                                        @break
                                    @case('published')
                                        <span class="badge-himapro badge-active">Published</span>
                                        @break
                                    @case('archived')
                                        <span class="badge-himapro badge-inactive">Diarsipkan</span>
                                        @break
                                @endswitch
                            </td>

                            <td>
                                @if ($pengumuman->is_published)
                                    <span class="badge-himapro badge-active">
                                        <i class="bi bi-globe"></i> Publik
                                    </span>
                                @else
                                    <span class="badge-himapro badge-inactive">
                                        <i class="bi bi-lock"></i> Internal
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div style="font-size: 12.5px;">
                                    {{ $pengumuman->published_at?->format('d M Y') ?? $pengumuman->created_at?->format('d M Y') }}
                                </div>
                                <div style="font-size: 10.5px; color: var(--muted); margin-top: 2px;">
                                    {{ $pengumuman->created_at?->format('H:i') }}
                                </div>
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.pengumuman.show', $pengumuman) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('pengumuman.update'))
                                        <a href="{{ route('admin.pengumuman.edit', $pengumuman) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('pengumuman.delete'))
                                        <form action="{{ route('admin.pengumuman.destroy', $pengumuman) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?')">
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
                                    <i class="bi bi-megaphone"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada pengumuman</h6>
                                <p class="mb-3">Buat pengumuman pertama HIMAPRO TI SAKTI.</p>

                                @if (auth()->user()->hasPermission('pengumuman.create'))
                                    <a href="{{ route('admin.pengumuman.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Pengumuman
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($pengumumans->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $pengumumans->links() }}
        </div>
    @endif

</div>

@endsection