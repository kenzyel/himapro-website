@extends('layouts.admin')

@section('title', 'Program Kerja')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Program Kerja</h1>
    <p>Kelola seluruh program kerja HIMAPRO TI SAKTI.</p>
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
                <h2 class="admin-card-title">Daftar Program Kerja</h2>
                <p class="card-subtitle">Total {{ $programKerjas->total() }} program kerja terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('program-kerja.create'))
                <a href="{{ route('admin.program-kerja.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Program Kerja
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
                        value="{{ $search }}"
                        placeholder="Cari program kerja..."
                    >
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Departemen</label>
                    <select name="departemen_id" class="form-select">
                        <option value="">Semua Departemen</option>
                        @foreach ($departemens as $departemen)
                            <option value="{{ $departemen->id }}" @selected((string) $departemenId === (string) $departemen->id)>
                                {{ $departemen->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="planned" @selected($status === 'planned')>Direncanakan</option>
                        <option value="ongoing" @selected($status === 'ongoing')>Berjalan</option>
                        <option value="completed" @selected($status === 'completed')>Selesai</option>
                        <option value="cancelled" @selected($status === 'cancelled')>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'departemen_id', 'status']))
                        <a href="{{ route('admin.program-kerja.index') }}" class="btn-icon" title="Reset">
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
                        <th>Program Kerja</th>
                        <th>Departemen</th>
                        <th>Periode</th>
                        <th>Waktu</th>
                        <th>Status</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($programKerjas as $index => $programKerja)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $programKerjas->firstItem() + $index }}
                            </td>

                            <td>
                                <div style="font-weight: 700; font-size: 13px;">
                                    {{ $programKerja->nama }}
                                </div>
                                <div style="font-size: 11px; color: var(--muted); margin-top: 2px;">
                                    {{ $programKerja->slug }}
                                </div>
                            </td>

                            <td>
                                @if ($programKerja->departemen)
                                    <span class="badge-himapro badge-yellow">
                                        {{ $programKerja->departemen->nama }}
                                    </span>
                                @else
                                    <span style="color: var(--muted);">—</span>
                                @endif
                            </td>

                            <td style="font-size: 12.5px; color: var(--muted);">
                                {{ $programKerja->periode }}
                            </td>

                            <td>
                                @if ($programKerja->tanggal_mulai)
                                    <div style="font-size: 12px;">
                                        {{ $programKerja->tanggal_mulai->format('d M Y') }}
                                    </div>
                                    @if ($programKerja->tanggal_selesai)
                                        <div style="font-size: 10.5px; color: var(--muted); margin-top: 2px;">
                                            s/d {{ $programKerja->tanggal_selesai->format('d M Y') }}
                                        </div>
                                    @endif
                                @else
                                    <span style="color: var(--muted); font-size: 11.5px;">Belum ditentukan</span>
                                @endif
                            </td>

                            <td>
                                @switch($programKerja->status)
                                    @case('planned')
                                        <span class="badge-himapro badge-yellow">Direncanakan</span>
                                        @break
                                    @case('ongoing')
                                        <span class="badge-himapro badge-active">Berjalan</span>
                                        @break
                                    @case('completed')
                                        <span class="badge-himapro badge-active">Selesai</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge-himapro badge-inactive">Dibatalkan</span>
                                        @break
                                    @default
                                        <span class="badge-himapro badge-yellow">{{ $programKerja->status }}</span>
                                @endswitch
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.program-kerja.show', $programKerja) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('program-kerja.update'))
                                        <a href="{{ route('admin.program-kerja.edit', $programKerja) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('program-kerja.delete'))
                                        <form action="{{ route('admin.program-kerja.destroy', $programKerja) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus program kerja ini?')">
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
                                    <i class="bi bi-kanban"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada program kerja</h6>
                                <p class="mb-3">Silakan tambahkan program kerja pertama.</p>

                                @if (auth()->user()->hasPermission('program-kerja.create'))
                                    <a href="{{ route('admin.program-kerja.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Program Kerja
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($programKerjas->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $programKerjas->links() }}
        </div>
    @endif

</div>

@endsection