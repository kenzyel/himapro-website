@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

@php
    $user = auth()->user();
    $can = fn($permission) => $user && $user->hasPermission($permission);
@endphp


{{-- GREETING --}}
<div class="mb-4" data-aos="fade-down">
    <h1 style="font-size: 24px; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 6px;">
        Selamat datang, {{ $user->name }} 👋
    </h1>
    <p style="color: var(--muted); font-size: 13px; margin: 0;">
        Berikut ringkasan aktivitas HIMAPRO TI SAKTI hari ini.
    </p>
</div>


{{-- STATISTICS UTAMA --}}
<section class="stats-grid">

    <div class="stat-card" data-aos="fade-up" data-aos-delay="0">
        <div class="stat-header">
            <span class="stat-label">Pengurus Aktif</span>
            <span class="stat-icon"><i class="bi bi-people-fill"></i></span>
        </div>
        <div class="stat-value" data-countup="{{ $totalPengurus }}">0</div>
        <div class="stat-description">Pengurus periode aktif</div>
    </div>

    <div class="stat-card" data-aos="fade-up" data-aos-delay="80">
        <div class="stat-header">
            <span class="stat-label">Departemen</span>
            <span class="stat-icon"><i class="bi bi-diagram-3-fill"></i></span>
        </div>
        <div class="stat-value" data-countup="{{ $totalDepartemen }}">0</div>
        <div class="stat-description">Departemen organisasi</div>
    </div>

    <div class="stat-card" data-aos="fade-up" data-aos-delay="160">
        <div class="stat-header">
            <span class="stat-label">Program Kerja</span>
            <span class="stat-icon"><i class="bi bi-kanban-fill"></i></span>
        </div>
        <div class="stat-value" data-countup="{{ $totalProgramKerja }}">0</div>
        <div class="stat-description">Program kerja terdaftar</div>
    </div>

    <div class="stat-card" data-aos="fade-up" data-aos-delay="240">
        <div class="stat-header">
            <span class="stat-label">Agenda</span>
            <span class="stat-icon"><i class="bi bi-calendar-event-fill"></i></span>
        </div>
        <div class="stat-value" data-countup="{{ $totalAgenda }}">0</div>
        <div class="stat-description">Agenda publik</div>
    </div>

</section>


{{-- KEUANGAN RINGKASAN — hanya tampil kalau punya akses keuangan --}}
@if ($can('keuangan.view') || $can('anggaran.view') || $can('laporan.view'))
    <section class="stats-grid" style="grid-template-columns: repeat(4, 1fr);">

        <div class="stat-card" data-aos="fade-up" data-aos-delay="0">
            <div class="stat-header">
                <span class="stat-label">Total Pemasukan</span>
                <span class="stat-icon" style="background: rgba(34,197,94,.1); color: #86efac; border-color: rgba(34,197,94,.2);">
                    <i class="bi bi-arrow-down-circle-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="font-size: 18px; color: #86efac;">
                Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
            </div>
            <div class="stat-description">Transaksi disetujui</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="80">
            <div class="stat-header">
                <span class="stat-label">Total Pengeluaran</span>
                <span class="stat-icon" style="background: rgba(239,68,68,.1); color: #fca5a5; border-color: rgba(239,68,68,.2);">
                    <i class="bi bi-arrow-up-circle-fill"></i>
                </span>
            </div>
            <div class="stat-value" style="font-size: 18px; color: #fca5a5;">
                Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
            </div>
            <div class="stat-description">Transaksi disetujui</div>
        </div>

        <div class="stat-card" data-aos="fade-up" data-aos-delay="160">
            <div class="stat-header">
                <span class="stat-label">Saldo</span>
                <span class="stat-icon"><i class="bi bi-wallet2"></i></span>
            </div>
            <div class="stat-value" style="font-size: 18px; color: var(--primary);">
                Rp {{ number_format($saldo, 0, ',', '.') }}
            </div>
            <div class="stat-description">Pemasukan - pengeluaran</div>
        </div>

        @if ($can('pesan.view'))
            <a
                href="{{ route('admin.pesan.index', ['status' => 'unread']) }}"
                class="stat-card"
                data-aos="fade-up"
                data-aos-delay="240"
                style="text-decoration: none; cursor: pointer;"
            >
                <div class="stat-header">
                    <span class="stat-label">Pesan Belum Dibaca</span>
                    <span class="stat-icon"><i class="bi bi-chat-dots-fill"></i></span>
                </div>
                <div class="stat-value" style="color: var(--primary);">{{ $pesanUnread }}</div>
                <div class="stat-description">Klik untuk lihat &rarr;</div>
            </a>
        @endif

    </section>
@endif


{{-- CHART ROW 1: Keuangan + Program Kerja --}}
<section class="dashboard-grid" style="grid-template-columns: 2fr 1fr; margin-bottom: 22px;">

    {{-- Line Chart: Tren Keuangan --}}
    @if ($can('keuangan.view') || $can('anggaran.view') || $can('laporan.view'))
        <div class="admin-card" data-aos="fade-up">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h2 class="admin-card-title">Tren Keuangan 6 Bulan</h2>
                        <p class="card-subtitle">Perbandingan pemasukan dan pengeluaran</p>
                    </div>

                    <div class="d-flex gap-3" style="font-size: 11.5px;">
                        <div class="d-flex align-items-center gap-2">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #86efac;"></span>
                            <span style="color: var(--muted); font-weight: 700;">Pemasukan</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #fca5a5;"></span>
                            <span style="color: var(--muted); font-weight: 700;">Pengeluaran</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 280px;">
                    <canvas id="chartKeuangan"></canvas>
                </div>
            </div>
        </div>
    @endif

    {{-- Doughnut Chart: Program Kerja --}}
    @if ($can('program-kerja.view'))
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header">
                <h2 class="admin-card-title">Status Program Kerja</h2>
                <p class="card-subtitle">Distribusi berdasarkan status</p>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 280px;">
                    <canvas id="chartProgramKerja"></canvas>
                </div>
            </div>
        </div>
    @endif

</section>


{{-- CHART ROW 2: Agenda + Anggaran --}}
<section class="dashboard-grid" style="grid-template-columns: 1fr 1fr; margin-bottom: 22px;">

    {{-- Bar Chart: Agenda --}}
    @if ($can('agenda.view'))
        <div class="admin-card" data-aos="fade-up">
            <div class="card-header">
                <h2 class="admin-card-title">Agenda 6 Bulan Terakhir</h2>
                <p class="card-subtitle">Jumlah agenda per bulan</p>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 260px;">
                    <canvas id="chartAgenda"></canvas>
                </div>
            </div>
        </div>
    @endif

    {{-- Doughnut Chart: Anggaran --}}
    @if ($can('anggaran.view'))
        <div class="admin-card" data-aos="fade-up" data-aos-delay="100">
            <div class="card-header">
                <h2 class="admin-card-title">Status Anggaran</h2>
                <p class="card-subtitle">Distribusi item anggaran</p>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 260px;">
                    <canvas id="chartAnggaran"></canvas>
                </div>
            </div>
        </div>
    @endif

</section>


{{-- AKSI CEPAT + AKUN --}}
<section class="dashboard-grid">

    {{-- QUICK ACTIONS --}}
    @if (
        $can('pengurus.view') ||
        $can('program-kerja.view') ||
        $can('agenda.view') ||
        $can('pengumuman.view')
    )
        <div class="admin-card" data-aos="fade-up">
            <div class="card-header">
                <div>
                    <h2 class="admin-card-title">Aksi Cepat</h2>
                    <p class="card-subtitle">Akses cepat ke pengelolaan organisasi</p>
                </div>
            </div>
            <div class="card-body">
                <div class="quick-actions">

                    @if ($can('pengurus.view'))
                        <a href="{{ route('admin.pengurus.index') }}" class="quick-action">
                            <div class="quick-action-icon"><i class="bi bi-people-fill"></i></div>
                            <strong>Kelola Pengurus</strong>
                            <span>Tambah dan edit struktur pengurus</span>
                        </a>
                    @endif

                    @if ($can('program-kerja.view'))
                        <a href="{{ route('admin.program-kerja.index') }}" class="quick-action">
                            <div class="quick-action-icon"><i class="bi bi-kanban-fill"></i></div>
                            <strong>Program Kerja</strong>
                            <span>Kelola program kerja organisasi</span>
                        </a>
                    @endif

                    @if ($can('agenda.create'))
                        <a href="{{ route('admin.agenda.create') }}" class="quick-action">
                            <div class="quick-action-icon"><i class="bi bi-calendar-event-fill"></i></div>
                            <strong>Buat Agenda</strong>
                            <span>Tambahkan agenda kegiatan</span>
                        </a>
                    @elseif ($can('agenda.view'))
                        <a href="{{ route('admin.agenda.index') }}" class="quick-action">
                            <div class="quick-action-icon"><i class="bi bi-calendar-event-fill"></i></div>
                            <strong>Lihat Agenda</strong>
                            <span>Daftar agenda kegiatan</span>
                        </a>
                    @endif

                    @if ($can('pengumuman.view'))
                        <a href="{{ route('admin.pengumuman.index') }}" class="quick-action">
                            <div class="quick-action-icon"><i class="bi bi-megaphone-fill"></i></div>
                            <strong>Pengumuman</strong>
                            <span>Publikasikan informasi terbaru</span>
                        </a>
                    @endif

                </div>
            </div>
        </div>
    @endif

    {{-- ACCOUNT --}}
    <div class="admin-card" data-aos="fade-up" data-aos-delay="100">
        <div class="card-header">
            <div>
                <h2 class="admin-card-title">Akun Anda</h2>
                <p class="card-subtitle">Informasi akses sistem</p>
            </div>
        </div>
        <div class="card-body">

            <div style="margin-bottom: 18px;">
                <div style="color: var(--muted); font-size: 11px; margin-bottom: 5px; letter-spacing:.05em; text-transform:uppercase; font-weight:700;">
                    Nama
                </div>
                <strong style="font-size: 13.5px;">{{ $user->name }}</strong>
            </div>

            <div style="margin-bottom: 18px;">
                <div style="color: var(--muted); font-size: 11px; margin-bottom: 5px; letter-spacing:.05em; text-transform:uppercase; font-weight:700;">
                    Email
                </div>
                <strong style="font-size: 13.5px;">{{ $user->email }}</strong>
            </div>

            <div>
                <div style="color: var(--muted); font-size: 11px; margin-bottom: 9px; letter-spacing:.05em; text-transform:uppercase; font-weight:700;">
                    Role
                </div>

                <span style="
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    padding: 7px 12px;
                    border-radius: 999px;
                    background: rgba(255, 210, 26, .12);
                    color: var(--primary);
                    border: 1px solid rgba(255, 210, 26, .25);
                    font-size: 11.5px;
                    font-weight: 800;
                    letter-spacing: .03em;
                    text-transform: uppercase;
                ">
                    <i class="bi bi-shield-fill-check"></i>
                    {{ $user->role?->name ?? 'Tanpa Role' }}
                </span>
            </div>

        </div>
    </div>

</section>

@endsection


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    Chart.defaults.color = '#929298';
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.font.size = 11;
    Chart.defaults.borderColor = 'rgba(255,255,255,.06)';

    const warna = {
        primary: '#FFD21A',
        secondary: '#F5A900',
        green: '#86efac',
        red: '#fca5a5',
        blue: '#93c5fd',
    };

    /* ====================================================
       CHART 1: LINE — Tren Keuangan
       ==================================================== */
    const ctxKeuangan = document.getElementById('chartKeuangan');
    if (ctxKeuangan) {
        new Chart(ctxKeuangan, {
            type: 'line',
            data: {
                labels: @json($bulanLabels ?? []),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($bulanPemasukan ?? []),
                        borderColor: warna.green,
                        backgroundColor: 'rgba(134, 239, 172, 0.1)',
                        borderWidth: 2.5,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: warna.green,
                        pointBorderColor: '#0B0B0D',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($bulanPengeluaran ?? []),
                        borderColor: warna.red,
                        backgroundColor: 'rgba(252, 165, 165, 0.1)',
                        borderWidth: 2.5,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: warna.red,
                        pointBorderColor: '#0B0B0D',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1D1D20',
                        borderColor: 'rgba(255,255,255,.1)',
                        borderWidth: 1,
                        titleColor: '#F5F3E8',
                        bodyColor: '#F5F3E8',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) {
                                return ctx.dataset.label + ': Rp ' + ctx.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(v) {
                                if (v >= 1000000) return 'Rp ' + (v / 1000000).toFixed(0) + 'Jt';
                                if (v >= 1000) return 'Rp ' + (v / 1000).toFixed(0) + 'Rb';
                                return 'Rp ' + v;
                            }
                        },
                        grid: { color: 'rgba(255,255,255,.04)' }
                    },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    /* ====================================================
       CHART 2: DOUGHNUT — Status Program Kerja
       ==================================================== */
    const ctxPK = document.getElementById('chartProgramKerja');
    if (ctxPK) {
        new Chart(ctxPK, {
            type: 'doughnut',
            data: {
                labels: ['Direncanakan', 'Berjalan', 'Selesai', 'Dibatalkan'],
                datasets: [{
                    data: [
                        {{ $programKerjaStatus['planned'] ?? 0 }},
                        {{ $programKerjaStatus['ongoing'] ?? 0 }},
                        {{ $programKerjaStatus['completed'] ?? 0 }},
                        {{ $programKerjaStatus['cancelled'] ?? 0 }},
                    ],
                    backgroundColor: [warna.primary, warna.blue, warna.green, warna.red],
                    borderColor: '#1D1D20',
                    borderWidth: 3,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 14, usePointStyle: true, pointStyle: 'circle', font: { size: 11, weight: '600' } }
                    },
                    tooltip: {
                        backgroundColor: '#1D1D20',
                        borderColor: 'rgba(255,255,255,.1)',
                        borderWidth: 1,
                        titleColor: '#F5F3E8',
                        bodyColor: '#F5F3E8',
                        padding: 12,
                        cornerRadius: 8,
                    }
                }
            }
        });
    }

    /* ====================================================
       CHART 3: BAR — Agenda per Bulan
       ==================================================== */
    const ctxAgenda = document.getElementById('chartAgenda');
    if (ctxAgenda) {
        new Chart(ctxAgenda, {
            type: 'bar',
            data: {
                labels: @json($agendaLabels ?? []),
                datasets: [{
                    label: 'Jumlah Agenda',
                    data: @json($agendaData ?? []),
                    backgroundColor: warna.primary,
                    borderRadius: 8,
                    borderSkipped: false,
                    barThickness: 'flex',
                    maxBarThickness: 40,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1D1D20',
                        borderColor: 'rgba(255,255,255,.1)',
                        borderWidth: 1,
                        titleColor: '#F5F3E8',
                        bodyColor: '#F5F3E8',
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(ctx) { return ctx.parsed.y + ' agenda'; }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(255,255,255,.04)' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    /* ====================================================
       CHART 4: DOUGHNUT — Status Anggaran
       ==================================================== */
    const ctxAnggaran = document.getElementById('chartAnggaran');
    if (ctxAnggaran) {
        new Chart(ctxAnggaran, {
            type: 'doughnut',
            data: {
                labels: ['Draft', 'Disetujui', 'Realisasi', 'Dibatalkan'],
                datasets: [{
                    data: [
                        {{ $anggaranStatus['draft'] ?? 0 }},
                        {{ $anggaranStatus['approved'] ?? 0 }},
                        {{ $anggaranStatus['realized'] ?? 0 }},
                        {{ $anggaranStatus['cancelled'] ?? 0 }},
                    ],
                    backgroundColor: [warna.primary, warna.green, warna.blue, warna.red],
                    borderColor: '#1D1D20',
                    borderWidth: 3,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { padding: 14, usePointStyle: true, pointStyle: 'circle', font: { size: 11, weight: '600' } }
                    },
                    tooltip: {
                        backgroundColor: '#1D1D20',
                        borderColor: 'rgba(255,255,255,.1)',
                        borderWidth: 1,
                        titleColor: '#F5F3E8',
                        bodyColor: '#F5F3E8',
                        padding: 12,
                        cornerRadius: 8,
                    }
                }
            }
        });
    }

});
</script>
@endpush