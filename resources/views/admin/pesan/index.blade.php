@extends('layouts.admin')

@section('title', 'Pesan Masuk')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>Pesan Masuk</h1>
        <p>Pesan dari form kontak website HIMAPRO TI SAKTI.</p>
    </div>

    @if ($stats['unread'] > 0)
        <form action="{{ route('admin.pesan.mark-all-read') }}"
              method="POST"
              onsubmit="return confirm('Tandai semua pesan sebagai sudah dibaca?')">
            @csrf
            @method('PATCH')

            <button type="submit" class="btn-himapro btn-himapro-secondary">
                <i class="bi bi-check2-all"></i>
                Tandai Semua Dibaca
            </button>
        </form>
    @endif
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


{{-- STATISTIK MINI --}}
<div class="row g-3 mb-4" data-aos="fade-up">
    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Pesan</span>
                <span class="stat-icon"><i class="bi bi-chat-dots-fill"></i></span>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-description">Semua pesan</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Belum Dibaca</span>
                <span class="stat-icon"><i class="bi bi-envelope-fill"></i></span>
            </div>
            <div class="stat-value" style="color: var(--primary);">{{ $stats['unread'] }}</div>
            <div class="stat-description">Perlu ditindaklanjuti</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Sudah Dibaca</span>
                <span class="stat-icon"><i class="bi bi-envelope-open-fill"></i></span>
            </div>
            <div class="stat-value">{{ $stats['read'] }}</div>
            <div class="stat-description">Sudah dilihat</div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Sudah Dibalas</span>
                <span class="stat-icon"><i class="bi bi-reply-fill"></i></span>
            </div>
            <div class="stat-value">{{ $stats['replied'] }}</div>
            <div class="stat-description">Ditindaklanjuti</div>
        </div>
    </div>
</div>


<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div>
            <h2 class="admin-card-title">Daftar Pesan</h2>
            <p class="card-subtitle">Total {{ $pesans->total() }} pesan terdaftar</p>
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
                        placeholder="Cari nama, email, subjek, isi pesan..."
                    >
                </div>

                <div class="col-lg-3 col-md-5">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="unread" @selected(request('status') === 'unread')>Belum Dibaca</option>
                        <option value="read" @selected(request('status') === 'read')>Sudah Dibaca</option>
                        <option value="replied" @selected(request('status') === 'replied')>Sudah Dibalas</option>
                        <option value="archived" @selected(request('status') === 'archived')>Diarsipkan</option>
                    </select>
                </div>

                <div class="col-lg-2 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn-himapro btn-himapro-primary flex-fill">
                        <i class="bi bi-funnel-fill"></i>
                        Filter
                    </button>

                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.pesan.index') }}" class="btn-icon" title="Reset">
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
                        <th>Pengirim</th>
                        <th>Subjek</th>
                        <th>Status</th>
                        <th>Waktu</th>
                        <th class="text-end px-4" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesans as $index => $pesan)
                        <tr style="{{ $pesan->status === 'unread' ? 'background: rgba(255,210,26,.03);' : '' }}">
                            <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                {{ $pesans->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="avatar-initials">
                                        {{ strtoupper(substr($pesan->nama, 0, 1)) }}
                                    </span>

                                    <div>
                                        <div style="font-weight: {{ $pesan->status === 'unread' ? '800' : '700' }}; font-size: 13px;">
                                            {{ $pesan->nama }}
                                            @if ($pesan->status === 'unread')
                                                <span style="
                                                    display: inline-block;
                                                    width: 6px;
                                                    height: 6px;
                                                    background: var(--primary);
                                                    border-radius: 50%;
                                                    margin-left: 6px;
                                                    box-shadow: 0 0 8px var(--primary);
                                                "></span>
                                            @endif
                                        </div>
                                        <div style="font-size: 11px; color: var(--muted);">
                                            {{ $pesan->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div style="font-size: 12.5px; font-weight: 600;">
                                    {{ \Illuminate\Support\Str::limit($pesan->subjek, 50) }}
                                </div>
                                <div style="font-size: 11px; color: var(--muted); margin-top: 2px;">
                                    {{ \Illuminate\Support\Str::limit($pesan->pesan, 60) }}
                                </div>
                            </td>

                            <td>
                                @switch($pesan->status)
                                    @case('unread')
                                        <span class="badge-himapro badge-yellow">
                                            <i class="bi bi-envelope-fill"></i> Belum Dibaca
                                        </span>
                                        @break
                                    @case('read')
                                        <span class="badge-himapro" style="background: rgba(59,130,246,.12); color: #93c5fd; border-color: rgba(59,130,246,.25);">
                                            <i class="bi bi-envelope-open-fill"></i> Dibaca
                                        </span>
                                        @break
                                    @case('replied')
                                        <span class="badge-himapro badge-active">
                                            <i class="bi bi-reply-fill"></i> Dibalas
                                        </span>
                                        @break
                                    @case('archived')
                                        <span class="badge-himapro" style="background: rgba(255,255,255,.05); color: var(--muted); border-color: var(--border);">
                                            <i class="bi bi-archive-fill"></i> Diarsipkan
                                        </span>
                                        @break
                                @endswitch
                            </td>

                            <td>
                                <div style="font-size: 12px;">
                                    {{ $pesan->created_at?->format('d M Y') }}
                                </div>
                                <div style="font-size: 10.5px; color: var(--muted);">
                                    {{ $pesan->created_at?->format('H:i') }}
                                </div>
                            </td>

                            <td class="text-end px-4">
                                <div class="table-actions">
                                    <a href="{{ route('admin.pesan.show', $pesan) }}"
                                       class="btn-icon"
                                       title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <form action="{{ route('admin.pesan.destroy', $pesan) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-icon danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Belum ada pesan</h6>
                                <p class="mb-0">Pesan dari form kontak website akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($pesans->hasPages())
        <div class="card-footer bg-transparent border-0 p-4">
            {{ $pesans->links() }}
        </div>
    @endif

</div>

@endsection