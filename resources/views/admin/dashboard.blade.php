@extends('layouts.admin')

@section('title', 'Dashboard')

@section('heading', 'Dashboard')

@section('content')

    {{-- STATISTICS --}}

    <section class="stats-grid">

        <div class="stat-card">

            <div class="stat-header">

                <span class="stat-label">
                    Pengurus Aktif
                </span>

                <span class="stat-icon">
                    ♙
                </span>

            </div>

            <div class="stat-value">
                {{ $totalPengurus }}
            </div>

            <div class="stat-description">
                Pengurus periode aktif
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-header">

                <span class="stat-label">
                    Departemen
                </span>

                <span class="stat-icon">
                    ◈
                </span>

            </div>

            <div class="stat-value">
                {{ $totalDepartemen }}
            </div>

            <div class="stat-description">
                Departemen organisasi
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-header">

                <span class="stat-label">
                    Program Kerja
                </span>

                <span class="stat-icon">
                    ▣
                </span>

            </div>

            <div class="stat-value">
                {{ $totalProgramKerja }}
            </div>

            <div class="stat-description">
                Program kerja terdaftar
            </div>

        </div>


        <div class="stat-card">

            <div class="stat-header">

                <span class="stat-label">
                    Agenda
                </span>

                <span class="stat-icon">
                    ◷
                </span>

            </div>

            <div class="stat-value">
                {{ $totalAgenda }}
            </div>

            <div class="stat-description">
                Agenda publik
            </div>

        </div>

    </section>


    {{-- DASHBOARD CONTENT --}}

    <section class="dashboard-grid">


        {{-- QUICK ACTIONS --}}

        <div class="card">

            <div class="card-header">

                <div>
                    <h2 class="card-title">
                        Aksi Cepat
                    </h2>

                    <p class="card-subtitle">
                        Akses cepat ke pengelolaan organisasi
                    </p>
                </div>

            </div>


            <div class="card-body">

                <div class="quick-actions">

                    <a href="#" class="quick-action">

                        <div class="quick-action-icon">
                            ♙
                        </div>

                        <strong>
                            Kelola Pengurus
                        </strong>

                        <span>
                            Tambah dan edit struktur pengurus
                        </span>

                    </a>


                    <a href="#" class="quick-action">

                        <div class="quick-action-icon">
                            ▣
                        </div>

                        <strong>
                            Program Kerja
                        </strong>

                        <span>
                            Kelola program kerja organisasi
                        </span>

                    </a>


                    <a href="#" class="quick-action">

                        <div class="quick-action-icon">
                            ◷
                        </div>

                        <strong>
                            Buat Agenda
                        </strong>

                        <span>
                            Tambahkan agenda kegiatan
                        </span>

                    </a>


                    <a href="#" class="quick-action">

                        <div class="quick-action-icon">
                            ◉
                        </div>

                        <strong>
                            Pengumuman
                        </strong>

                        <span>
                            Publikasikan informasi terbaru
                        </span>

                    </a>

                </div>

            </div>

        </div>


        {{-- ACCOUNT --}}

        <div class="card">

            <div class="card-header">

                <div>
                    <h2 class="card-title">
                        Akun Anda
                    </h2>

                    <p class="card-subtitle">
                        Informasi akses sistem
                    </p>
                </div>

            </div>


            <div class="card-body">

                <div style="margin-bottom: 16px;">

                    <div
                        style="
                            color: var(--muted);
                            font-size: 11px;
                            margin-bottom: 5px;
                        "
                    >
                        Nama
                    </div>

                    <strong style="font-size: 13px;">
                        {{ $user->name }}
                    </strong>

                </div>


                <div style="margin-bottom: 16px;">

                    <div
                        style="
                            color: var(--muted);
                            font-size: 11px;
                            margin-bottom: 5px;
                        "
                    >
                        Email
                    </div>

                    <strong style="font-size: 13px;">
                        {{ $user->email }}
                    </strong>

                </div>


                <div>

                    <div
                        style="
                            color: var(--muted);
                            font-size: 11px;
                            margin-bottom: 7px;
                        "
                    >
                        Role
                    </div>

                    <span
                        style="
                            display: inline-block;
                            padding: 6px 10px;
                            border-radius: 999px;
                            background: rgba(255, 210, 26, .12);
                            color: var(--yellow);
                            font-size: 11px;
                            font-weight: 700;
                        "
                    >
                        {{ $user->role?->name ?? 'Tanpa Role' }}
                    </span>

                </div>

            </div>

        </div>

    </section>

@endsection