@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Gallery</h1>
    <p>Kelola galeri kegiatan HIMAPRO TI SAKTI.</p>
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
                <h2 class="admin-card-title">Daftar Gallery</h2>
                <p class="card-subtitle">Total {{ $galleries->total() }} gallery terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('gallery.create'))
                <a href="{{ route('admin.gallery.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Gallery
                </a>
            @endif
        </div>
    </div>


    {{-- FILTER --}}
    <div class="px-4 pt-4">
        <form method="GET" class="filter-card">
            <div class="row g-2">

                <div class="col-lg-7 col-md-7">
                    <label class="form-label">Pencarian</label>
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau deskripsi gallery..."
                    >
                </div>

                <div class="col-lg-3 col-md-5">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                        <option value="published" @selected(request('status') === 'published')>Published</option>
                        <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.gallery.index') }}" class="btn-icon" title="Reset">
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
                        <th>Gallery</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($galleries as $index => $gallery)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $galleries->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if ($gallery->cover)
                                        <img src="{{ asset('storage/' . $gallery->cover) }}"
                                             alt="{{ $gallery->nama }}"
                                             style="
                                                width: 48px;
                                                height: 48px;
                                                border-radius: 10px;
                                                object-fit: cover;
                                                border: 1px solid var(--border);
                                             ">
                                    @else
                                        <div style="
                                            width: 48px;
                                            height: 48px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            border-radius: 10px;
                                            background: rgba(255,210,26,.1);
                                            border: 1px solid rgba(255,210,26,.2);
                                            color: var(--primary);
                                            font-size: 18px;
                                        ">
                                            <i class="bi bi-images"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <div style="font-weight: 700; font-size: 13px;">
                                            {{ $gallery->nama }}
                                        </div>
                                        <div style="font-size: 11px; color: var(--muted);">
                                            {{ $gallery->slug }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td style="font-size: 12.5px; color: var(--muted);">
                                {{ $gallery->tanggal?->format('d M Y') ?? '—' }}
                            </td>

                            <td>
                                @switch($gallery->status)
                                    @case('published')
                                        <span class="badge-himapro badge-active">Published</span>
                                        @break
                                    @case('draft')
                                        <span class="badge-himapro badge-yellow">Draft</span>
                                        @break
                                    @case('archived')
                                        <span class="badge-himapro badge-inactive">Archived</span>
                                        @break
                                @endswitch
                            </td>

                            <td>
                                <span class="badge-himapro badge-yellow">
                                    <i class="bi bi-camera"></i>
                                    {{ $gallery->items->count() }} foto
                                </span>
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.gallery.show', $gallery) }}"
                                       class="btn-icon"
                                       title="Lihat & Kelola Foto">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('gallery.update'))
                                        <a href="{{ route('admin.gallery.edit', $gallery) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('gallery.delete'))
                                        <form action="{{ route('admin.gallery.destroy', $gallery) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus gallery ini?')">
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
                                    <i class="bi bi-images"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada gallery</h6>
                                <p class="mb-3">Tambahkan gallery pertama HIMAPRO TI SAKTI.</p>

                                @if (auth()->user()->hasPermission('gallery.create'))
                                    <a href="{{ route('admin.gallery.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Gallery
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($galleries->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $galleries->links() }}
        </div>
    @endif

</div>

@endsection