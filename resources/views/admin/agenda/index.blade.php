@extends('layouts.admin')

@section('title', 'Agenda')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Agenda</h1>
    <p>Kelola seluruh agenda dan kegiatan HIMAPRO TI SAKTI.</p>
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
                <h2 class="admin-card-title">Daftar Agenda</h2>
                <p class="card-subtitle">Total {{ $agendas->total() }} agenda terdaftar</p>
            </div>

            @if (auth()->user()->hasPermission('agenda.create'))
                <a href="{{ route('admin.agenda.create') }}" class="btn-himapro btn-himapro-primary">
                    <i class="bi bi-plus-lg"></i>
                    Tambah Agenda
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
                        placeholder="Cari judul, lokasi..."
                    >
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">Program Kerja</label>
                    <select name="program_kerja_id" class="form-select">
                        <option value="">Semua Program Kerja</option>
                        @foreach ($programKerjas as $programKerja)
                            <option value="{{ $programKerja->id }}" @selected(request('program_kerja_id') == $programKerja->id)>
                                {{ $programKerja->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="planned" @selected(request('status') === 'planned')>Direncanakan</option>
                        <option value="ongoing" @selected(request('status') === 'ongoing')>Berlangsung</option>
                        <option value="completed" @selected(request('status') === 'completed')>Selesai</option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Publikasi</label>
                    <select name="is_public" class="form-select">
                        <option value="">Semua</option>
                        <option value="1" @selected(request('is_public') === '1')>Publik</option>
                        <option value="0" @selected(request('is_public') === '0')>Internal</option>
                    </select>
                </div>

                <div class="col-lg-1 col-md-6 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                    </button>

                    @if(request()->hasAny(['search', 'program_kerja_id', 'status', 'is_public']))
                        <a href="{{ route('admin.agenda.index') }}" class="btn-icon" title="Reset">
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
                        <th>Agenda</th>
                        <th>Program Kerja</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Publikasi</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agendas as $index => $agenda)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $agendas->firstItem() + $index }}
                            </td>

                            <td>
                                <div style="font-weight: 700; font-size: 13px;">
                                    {{ $agenda->judul }}
                                </div>
                                @if ($agenda->lokasi)
                                    <div style="font-size: 11px; color: var(--muted); margin-top: 2px;">
                                        <i class="bi bi-geo-alt"></i> {{ $agenda->lokasi }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                @if ($agenda->programKerja)
                                    <span class="badge-himapro badge-yellow">
                                        {{ $agenda->programKerja->nama }}
                                    </span>
                                @else
                                    <span style="color: var(--muted); font-size: 12px;">Tanpa program</span>
                                @endif
                            </td>

                            <td>
                                <div style="font-size: 12.5px;">
                                    {{ $agenda->tanggal_mulai?->format('d M Y') }}
                                </div>
                                <div style="font-size: 10.5px; color: var(--muted); margin-top: 2px;">
                                    {{ $agenda->tanggal_mulai?->format('H:i') }}
                                    @if ($agenda->tanggal_selesai)
                                        – {{ $agenda->tanggal_selesai->format('H:i') }}
                                    @endif
                                </div>
                            </td>

                            <td>
                                @switch($agenda->status)
                                    @case('planned')
                                        <span class="badge-himapro badge-yellow">Direncanakan</span>
                                        @break
                                    @case('ongoing')
                                        <span class="badge-himapro badge-active">Berlangsung</span>
                                        @break
                                    @case('completed')
                                        <span class="badge-himapro badge-active">Selesai</span>
                                        @break
                                    @case('cancelled')
                                        <span class="badge-himapro badge-inactive">Dibatalkan</span>
                                        @break
                                @endswitch
                            </td>

                            <td>
                                @if ($agenda->is_public)
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
                                    <a href="{{ route('admin.agenda.show', $agenda) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    @if (auth()->user()->hasPermission('agenda.update'))
                                        <a href="{{ route('admin.agenda.edit', $agenda) }}"
                                           class="btn-icon"
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    @endif

                                    @if (auth()->user()->hasPermission('agenda.delete'))
                                        <form action="{{ route('admin.agenda.destroy', $agenda) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus agenda ini?')">
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
                                    <i class="bi bi-calendar-x"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada agenda</h6>
                                <p class="mb-3">Tambahkan agenda pertama HIMAPRO TI SAKTI.</p>

                                @if (auth()->user()->hasPermission('agenda.create'))
                                    <a href="{{ route('admin.agenda.create') }}" class="btn-himapro btn-himapro-primary">
                                        <i class="bi bi-plus-lg"></i>
                                        Tambah Agenda
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($agendas->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $agendas->links() }}
        </div>
    @endif

</div>

@endsection