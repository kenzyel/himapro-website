@extends('layouts.admin')

@section('title', 'Detail Departemen')

@section('content')

<a href="{{ route('admin.departemen.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Departemen
</a>

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>{{ $departemen->nama }}</h1>
        <p>{{ $departemen->deskripsi ?: 'Detail informasi departemen.' }}</p>
    </div>

    @if (auth()->user()->hasPermission('departemen.update'))
        <a href="{{ route('admin.departemen.edit', $departemen) }}" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-pencil"></i>
            Edit
        </a>
    @endif
</div>


<div class="row g-4">

    <div class="col-lg-8">
        <div class="admin-card" data-aos="fade-up">

            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                    <div class="d-flex align-items-center gap-3">
                        <div style="
                            width: 52px;
                            height: 52px;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            border-radius: 14px;
                            background: {{ $departemen->warna ?: '#FFD21A' }};
                            color: #111;
                            font-size: 22px;
                            box-shadow: 0 6px 20px rgba(0,0,0,.35);
                        ">
                            <i class="bi {{ $departemen->icon ?: 'bi-diagram-3-fill' }}"></i>
                        </div>

                        <div>
                            <h2 class="admin-card-title">{{ $departemen->nama }}</h2>
                            <p class="card-subtitle">Kode: {{ $departemen->kode }}</p>
                        </div>
                    </div>

                    @if ($departemen->status === 'active')
                        <span class="badge-himapro badge-active">Aktif</span>
                    @else
                        <span class="badge-himapro badge-inactive">Non-Aktif</span>
                    @endif
                </div>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Nama</div>
                        <div class="info-block-value">{{ $departemen->nama }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Kode</div>
                        <div class="info-block-value">{{ $departemen->kode }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Slug</div>
                        <div class="info-block-value" style="font-weight: 500; color: var(--muted);">
                            <code>{{ $departemen->slug }}</code>
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Urutan</div>
                        <div class="info-block-value">{{ $departemen->urutan }}</div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Warna</div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span style="
                                width: 28px;
                                height: 28px;
                                border-radius: 8px;
                                background: {{ $departemen->warna ?: '#FFD21A' }};
                                border: 1px solid rgba(255,255,255,.15);
                            "></span>
                            <span style="font-size: 12.5px;">{{ $departemen->warna ?: '—' }}</span>
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Icon</div>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <i class="bi {{ $departemen->icon ?: 'bi-diagram-3-fill' }}"
                               style="font-size: 22px; color: var(--primary);"></i>
                            <span style="font-size: 12.5px;">{{ $departemen->icon ?: 'bi-diagram-3-fill' }}</span>
                        </div>
                    </div>

                    <div class="col-12 info-block">
                        <div class="info-block-label">Deskripsi</div>
                        <div class="info-block-value" style="font-weight: 500; line-height: 1.8;">
                            {!! nl2br(e($departemen->deskripsi ?: 'Belum ada deskripsi.')) !!}
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>


    <div class="col-lg-4">
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">

            <div class="card-header">
                <h2 class="admin-card-title">Statistik</h2>
                <p class="card-subtitle">Ringkasan data departemen</p>
            </div>

            <div class="card-body">

                <div class="stat-mini">
                    <div class="stat-mini-label">
                        <i class="bi bi-people-fill"></i>
                        Total Pengurus
                    </div>
                    <div class="stat-mini-value">{{ $departemen->pengurus->count() }}</div>
                </div>

                <div class="stat-mini">
                    <div class="stat-mini-label">
                        <i class="bi bi-kanban-fill"></i>
                        Program Kerja
                    </div>
                    <div class="stat-mini-value">{{ $departemen->programKerjas->count() }}</div>
                </div>

                <div class="stat-mini" style="margin-bottom: 0;">
                    <div class="stat-mini-label">
                        <i class="bi bi-sort-numeric-up"></i>
                        Urutan
                    </div>
                    <div class="stat-mini-value">{{ $departemen->urutan }}</div>
                </div>

            </div>

        </div>
    </div>

</div>


<div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="150">

    <div class="card-header">
        <h2 class="admin-card-title">Pengurus Departemen</h2>
        <p class="card-subtitle">Anggota yang tergabung dalam departemen ini</p>
    </div>

    <div class="card-body p-0">

        @if ($departemen->pengurus->count() > 0)
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="px-4">Nama</th>
                            <th>Jabatan</th>
                            <th>Tipe</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($departemen->pengurus as $pengurus)
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center gap-3">
                                        @if ($pengurus->foto)
                                            <img src="{{ asset('storage/' . $pengurus->foto) }}"
                                                 alt="{{ $pengurus->nama }}"
                                                 class="avatar-photo">
                                        @else
                                            <span class="avatar-initials">
                                                {{ strtoupper(substr($pengurus->nama, 0, 1)) }}
                                            </span>
                                        @endif
                                        <div style="font-weight: 700; font-size: 13px;">
                                            {{ $pengurus->nama }}
                                        </div>
                                    </div>
                                </td>
                                <td style="font-size: 12.5px;">{{ $pengurus->jabatan }}</td>
                                <td>
                                    <span class="badge-himapro badge-yellow">
                                        {{ strtoupper($pengurus->tipe_jabatan) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($pengurus->status === 'active')
                                        <span class="badge-himapro badge-active">Aktif</span>
                                    @else
                                        <span class="badge-himapro badge-inactive">Non-Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-people"></i>
                </div>
                <p class="mb-0">Belum ada pengurus pada departemen ini.</p>
            </div>
        @endif

    </div>

</div>


<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.departemen.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    @if (auth()->user()->hasPermission('departemen.update'))
        <a href="{{ route('admin.departemen.edit', $departemen) }}" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-pencil"></i>
            Edit Departemen
        </a>
    @endif
</div>

@endsection