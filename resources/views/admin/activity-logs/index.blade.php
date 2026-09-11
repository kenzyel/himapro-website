@extends('layouts.admin')

@section('title', 'Activity Log')

@section('content')

<div class="page-header" data-aos="fade-down">
    <h1>Activity Log</h1>
    <p>Riwayat aktivitas sistem HIMAPRO TI SAKTI — otomatis tercatat.</p>
</div>


{{-- STATISTIK --}}
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Aktivitas</span>
                <span class="stat-icon"><i class="bi bi-clock-history"></i></span>
            </div>
            <div class="stat-value">{{ number_format($stats['total']) }}</div>
            <div class="stat-description">Semua log</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Hari Ini</span>
                <span class="stat-icon" style="background: rgba(59,130,246,.1); color: #93c5fd; border-color: rgba(59,130,246,.2);">
                    <i class="bi bi-calendar-day"></i>
                </span>
            </div>
            <div class="stat-value" style="color: #93c5fd;">{{ $stats['today'] }}</div>
            <div class="stat-description">Aktivitas hari ini</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Ditambahkan</span>
                <span class="stat-icon" style="background: rgba(34,197,94,.1); color: #86efac; border-color: rgba(34,197,94,.2);">
                    <i class="bi bi-plus-circle-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="color: #86efac;">{{ number_format($stats['created']) }}</div>
            <div class="stat-description">Data baru</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Diperbarui</span>
                <span class="stat-icon" style="background: rgba(255,210,26,.1); color: var(--primary); border-color: rgba(255,210,26,.2);">
                    <i class="bi bi-pencil-square"></i>
                </span>
            </div>
            <div class="stat-value" style="color: var(--primary);">{{ number_format($stats['updated']) }}</div>
            <div class="stat-description">Data diubah</div>
        </div>
    </div>
</div>


<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div>
            <h2 class="admin-card-title">Riwayat Aktivitas</h2>
            <p class="card-subtitle">Total {{ $logs->total() }} aktivitas tercatat</p>
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
                        placeholder="Cari deskripsi, action, module..."
                    >
                </div>

                <div class="col-lg-3 col-md-6">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-select">
                        <option value="">Semua User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(request('user_id') == $user->id)>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Action</label>
                    <select name="action" class="form-select">
                        <option value="">Semua</option>
                        @foreach ($actions as $action)
                            <option value="{{ $action }}" @selected(request('action') === $action)>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-6">
                    <label class="form-label">Module</label>
                    <select name="module" class="form-select">
                        <option value="">Semua</option>
                        @foreach ($modules as $module)
                            <option value="{{ $module }}" @selected(request('module') === $module)>
                                {{ ucfirst($module) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-1 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                    </button>

                    @if(request()->hasAny(['search', 'user_id', 'action', 'module', 'from', 'to']))
                        <a href="{{ route('admin.activity-logs.index') }}" class="btn-icon" title="Reset">
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
                        <th>User</th>
                        <th>Action</th>
                        <th>Module</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                        <th class="text-end px-4" width="80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $index => $log)
                        <tr>
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $logs->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="avatar-initials">
                                        {{ strtoupper(substr($log->user?->name ?? 'S', 0, 1)) }}
                                    </span>
                                    <div>
                                        <div style="font-weight: 700; font-size: 12.5px;">
                                            {{ $log->user?->name ?? 'System' }}
                                        </div>
                                        <div style="font-size: 10.5px; color: var(--muted);">
                                            {{ $log->user?->email ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                @switch($log->action)
                                    @case('created')
                                        <span class="badge-himapro badge-active">
                                            <i class="bi bi-plus-circle-fill"></i> Dibuat
                                        </span>
                                        @break
                                    @case('updated')
                                        <span class="badge-himapro badge-yellow">
                                            <i class="bi bi-pencil-fill"></i> Diubah
                                        </span>
                                        @break
                                    @case('deleted')
                                        <span class="badge-himapro badge-inactive">
                                            <i class="bi bi-trash-fill"></i> Dihapus
                                        </span>
                                        @break
                                    @default
                                        <span class="badge-himapro" style="background: rgba(255,255,255,.05); color: var(--muted); border-color: var(--border);">
                                            {{ ucfirst($log->action) }}
                                        </span>
                                @endswitch
                            </td>

                            <td>
                                @if ($log->module)
                                    <span class="badge-himapro" style="background: rgba(255,255,255,.05); color: var(--muted); border-color: var(--border);">
                                        {{ $log->module }}
                                    </span>
                                @else
                                    <span style="color: var(--muted);">—</span>
                                @endif
                            </td>

                            <td style="font-size: 12px; color: var(--muted); max-width: 320px;">
                                {{ \Illuminate\Support\Str::limit($log->description, 80) ?: '—' }}
                            </td>

                            <td>
                                <div style="font-size: 12px;">
                                    {{ $log->created_at?->format('d M Y') }}
                                </div>
                                <div style="font-size: 10.5px; color: var(--muted);">
                                    {{ $log->created_at?->format('H:i:s') }}
                                </div>
                            </td>

                            <td class="text-end px-4">
                                <a href="{{ route('admin.activity-logs.show', $log) }}"
                                   class="btn-icon"
                                   title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada aktivitas</h6>
                                <p class="mb-0">Aktivitas akan tercatat otomatis begitu ada perubahan data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($logs->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $logs->links() }}
        </div>
    @endif

</div>

@endsection