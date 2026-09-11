@extends('layouts.admin')

@section('title', 'Detail Activity Log')

@section('content')

<a href="{{ route('admin.activity-logs.index') }}" class="page-header-breadcrumb" data-aos="fade-down">
    <i class="bi bi-arrow-left"></i>
    Kembali ke Activity Log
</a>

<div class="page-header" data-aos="fade-down">
    <h1>Detail Aktivitas</h1>
    <p>Informasi lengkap aktivitas yang tercatat.</p>
</div>


<div class="row g-4">

    {{-- DETAIL UTAMA --}}
    <div class="col-lg-8">

        <div class="admin-card" data-aos="fade-up">
            <div class="card-header">
                <h2 class="admin-card-title">Aktivitas</h2>
            </div>
            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Action</div>
                        <div>
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
                                    <span class="badge-himapro badge-yellow">
                                        {{ ucfirst($log->action) }}
                                    </span>
                            @endswitch
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Module</div>
                        <div class="info-block-value">
                            {{ $log->module ? ucfirst($log->module) : '—' }}
                        </div>
                    </div>

                    <div class="col-12 info-block">
                        <div class="info-block-label">Deskripsi</div>
                        <div class="info-block-value" style="font-weight: 500;">
                            {{ $log->description ?: 'Tidak ada deskripsi.' }}
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Subject Type</div>
                        <div class="info-block-value" style="font-weight: 500; color: var(--muted);">
                            <code>{{ $log->subject_type ?: '—' }}</code>
                        </div>
                    </div>

                    <div class="col-md-6 info-block">
                        <div class="info-block-label">Subject ID</div>
                        <div class="info-block-value" style="font-weight: 500; color: var(--muted);">
                            <code>{{ $log->subject_id ?: '—' }}</code>
                        </div>
                    </div>

                </div>

            </div>
        </div>


        {{-- OLD & NEW VALUES --}}
        @if ($log->old_values || $log->new_values)

            <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-header">
                    <h2 class="admin-card-title">Perubahan Data</h2>
                    <p class="card-subtitle">Nilai sebelum dan sesudah</p>
                </div>
                <div class="card-body">

                    <div class="row g-3">

                        @if ($log->old_values)
                            <div class="{{ $log->new_values ? 'col-md-6' : 'col-12' }}">
                                <div class="info-block-label" style="color: #fca5a5;">Nilai Lama</div>
                                <pre style="
                                    padding: 14px;
                                    background: rgba(239, 68, 68, 0.05);
                                    border: 1px solid rgba(239, 68, 68, 0.2);
                                    border-radius: 10px;
                                    color: #fca5a5;
                                    font-size: 11.5px;
                                    overflow-x: auto;
                                    margin: 0;
                                    max-height: 400px;
                                ">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                            </div>
                        @endif

                        @if ($log->new_values)
                            <div class="{{ $log->old_values ? 'col-md-6' : 'col-12' }}">
                                <div class="info-block-label" style="color: #86efac;">Nilai Baru</div>
                                <pre style="
                                    padding: 14px;
                                    background: rgba(34, 197, 94, 0.05);
                                    border: 1px solid rgba(34, 197, 94, 0.2);
                                    border-radius: 10px;
                                    color: #86efac;
                                    font-size: 11.5px;
                                    overflow-x: auto;
                                    margin: 0;
                                    max-height: 400px;
                                ">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}</pre>
                            </div>
                        @endif

                    </div>

                </div>
            </div>

        @else

            <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card-body">
                    <div style="
                        text-align: center;
                        padding: 30px 20px;
                        color: var(--muted);
                        font-size: 13px;
                    ">
                        <i class="bi bi-info-circle" style="font-size: 32px; display: block; margin-bottom: 10px; opacity: 0.5;"></i>
                        Tidak ada data perubahan yang dicatat untuk aktivitas ini.
                    </div>
                </div>
            </div>

        @endif

    </div>


    {{-- SIDEBAR INFO --}}
    <div class="col-lg-4">

        <div class="admin-card" data-aos="fade-up" data-aos-delay="150">
            <div class="card-header">
                <h2 class="admin-card-title">Informasi User</h2>
            </div>
            <div class="card-body">

                @if ($log->user)

                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="avatar-initials" style="width: 48px; height: 48px; font-size: 18px;">
                            {{ strtoupper(substr($log->user->name, 0, 1)) }}
                        </span>
                        <div>
                            <div style="font-weight: 700; font-size: 13.5px;">
                                {{ $log->user->name }}
                            </div>
                            <div style="font-size: 11.5px; color: var(--muted);">
                                {{ $log->user->email }}
                            </div>
                        </div>
                    </div>

                    <div class="info-block" style="margin-bottom: 0;">
                        <div class="info-block-label">Role</div>
                        <div class="info-block-value">
                            <span class="badge-himapro badge-yellow">
                                {{ $log->user->role?->name ?? 'Tanpa Role' }}
                            </span>
                        </div>
                    </div>

                @else

                    <div class="info-block" style="margin-bottom: 0;">
                        <div class="info-block-label">User</div>
                        <div class="info-block-value muted">
                            System / Anonymous
                        </div>
                    </div>

                @endif

            </div>
        </div>


        <div class="admin-card mt-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card-header">
                <h2 class="admin-card-title">Metadata</h2>
            </div>
            <div class="card-body">

                <div class="info-block">
                    <div class="info-block-label">IP Address</div>
                    <div class="info-block-value" style="font-weight: 500;">
                        <code>{{ $log->ip_address ?: '—' }}</code>
                    </div>
                </div>

                <div class="info-block">
                    <div class="info-block-label">User Agent</div>
                    <div class="info-block-value" style="font-weight: 500; font-size: 12px; line-height: 1.6; color: var(--muted); word-break: break-all;">
                        {{ $log->user_agent ?: '—' }}
                    </div>
                </div>

                <div class="info-block" style="margin-bottom: 0;">
                    <div class="info-block-label">Waktu</div>
                    <div class="info-block-value">
                        {{ $log->created_at?->format('d F Y, H:i:s') }}
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>


{{-- TOMBOL --}}
<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('admin.activity-logs.index') }}" class="btn-himapro btn-himapro-secondary">
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>
</div>

@endsection