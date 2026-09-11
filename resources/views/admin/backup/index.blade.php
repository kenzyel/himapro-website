@extends('layouts.admin')

@section('title', 'Backup Database')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4" data-aos="fade-down">
    <div class="page-header" style="margin-bottom: 0;">
        <h1>Backup Database</h1>
        <p>Kelola backup database HIMAPRO TI SAKTI.</p>
    </div>

    <form action="{{ route('admin.backup.create') }}"
          method="POST"
          onsubmit="return confirm('Buat backup database sekarang?\n\nProses ini mungkin memakan waktu beberapa detik.')">
        @csrf
        <button type="submit" class="btn-himapro btn-himapro-primary">
            <i class="bi bi-cloud-arrow-down-fill"></i>
            Backup Sekarang
        </button>
    </form>
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
    <div class="col-lg-4 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Backup</span>
                <span class="stat-icon"><i class="bi bi-archive-fill"></i></span>
            </div>
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-description">File tersimpan</div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Ukuran</span>
                <span class="stat-icon"><i class="bi bi-hdd-fill"></i></span>
            </div>
            <div class="stat-value" style="font-size: 22px;">
                {{ number_format($stats['total_size'] / 1024 / 1024, 2) }} MB
            </div>
            <div class="stat-description">Disk terpakai</div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Backup Terakhir</span>
                <span class="stat-icon"><i class="bi bi-clock-history"></i></span>
            </div>
            <div class="stat-value" style="font-size: 14px; line-height: 1.4; margin-top: 8px;">
                @if ($stats['latest'])
                    {{ date('d M Y', $stats['latest']) }}
                    <br>
                    <span style="font-size: 12px; color: var(--muted); font-weight: 600;">
                        {{ date('H:i', $stats['latest']) }}
                    </span>
                @else
                    <span style="color: var(--muted); font-size: 13px;">Belum ada</span>
                @endif
            </div>
        </div>
    </div>
</div>


{{-- INFO --}}
<div class="alert alert-warning" data-aos="fade-up" style="margin-bottom: 22px;">
    <i class="bi bi-info-circle-fill"></i>
    <div>
        <strong>Info:</strong> Sistem menyimpan maksimal <strong>10 backup terbaru</strong>.
        File lama akan otomatis dihapus saat backup baru dibuat.
        <br>
        Format nama: <code>backup-himapro-YYYY-MM-DD-HHMMSS.sql</code>
    </div>
</div>


{{-- DAFTAR BACKUP --}}
<div class="admin-card" data-aos="fade-up">

    <div class="card-header">
        <div>
            <h2 class="admin-card-title">Daftar Backup</h2>
            <p class="card-subtitle">
                {{ $stats['total'] > 0 ? $stats['total'] . ' file tersimpan' : 'Belum ada backup' }}
            </p>
        </div>
    </div>

    <div class="card-body p-0">

        @if (count($backups) > 0)

            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="px-4" width="60">#</th>
                            <th>Nama File</th>
                            <th>Ukuran</th>
                            <th>Dibuat</th>
                            <th class="text-end px-4" width="180">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($backups as $index => $backup)
                            <tr>
                                <td class="px-4" style="color: var(--muted); font-size: 12px;">
                                    {{ $index + 1 }}
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div style="
                                            width: 40px;
                                            height: 40px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            border-radius: 10px;
                                            background: rgba(255,210,26,.1);
                                            border: 1px solid rgba(255,210,26,.2);
                                            color: var(--primary);
                                            font-size: 18px;
                                            flex-shrink: 0;
                                        ">
                                            <i class="bi bi-filetype-sql"></i>
                                        </div>

                                        <div>
                                            <div style="font-weight: 700; font-size: 12.5px; word-break: break-all;">
                                                {{ $backup['filename'] }}
                                            </div>
                                            @if ($index === 0)
                                                <span class="badge-himapro badge-active" style="font-size: 9px; padding: 2px 6px; margin-top: 3px; display: inline-block;">
                                                    Terbaru
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td style="font-size: 12.5px; color: var(--muted);">
                                    @if ($backup['size'] >= 1024 * 1024)
                                        {{ number_format($backup['size'] / 1024 / 1024, 2) }} MB
                                    @elseif ($backup['size'] >= 1024)
                                        {{ number_format($backup['size'] / 1024, 1) }} KB
                                    @else
                                        {{ $backup['size'] }} B
                                    @endif
                                </td>

                                <td>
                                    <div style="font-size: 12.5px;">
                                        {{ date('d M Y', $backup['created_at']) }}
                                    </div>
                                    <div style="font-size: 10.5px; color: var(--muted);">
                                        {{ date('H:i:s', $backup['created_at']) }}
                                    </div>
                                </td>

                                <td class="text-end px-4">
                                    <div class="table-actions">
                                        <a href="{{ route('admin.backup.download', $backup['filename']) }}"
                                           class="btn-icon"
                                           title="Download">
                                            <i class="bi bi-download"></i>
                                        </a>

                                        <form action="{{ route('admin.backup.destroy', $backup['filename']) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus backup ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon danger" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else

            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="bi bi-archive"></i>
                </div>
                <h6 class="fw-bold mb-2">Belum ada backup</h6>
                <p class="mb-3">Klik tombol "Backup Sekarang" untuk membuat backup pertama.</p>
            </div>

        @endif

    </div>

</div>

@endsection