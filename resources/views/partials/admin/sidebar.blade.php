<aside class="admin-sidebar" id="adminSidebar">

    {{-- MOBILE CLOSE BUTTON --}}
    <button
        type="button"
        class="admin-sidebar-close"
        onclick="closeSidebar()"
        aria-label="Close Sidebar"
    >
        <i class="bi bi-x-lg"></i>
    </button>


    {{-- BRAND + TOGGLE --}}
    <div class="admin-brand">

        <div class="admin-brand-inner">

            <div class="admin-brand-left">

                @if (! empty($appSettings['site_logo']))
                    <div class="admin-brand-logo">
                        <img
                            src="{{ asset('storage/' . $appSettings['site_logo']) }}"
                            alt="{{ $appSettings['site_name'] ?? 'HIMAPRO TI SAKTI' }}"
                        >
                    </div>
                @else
                    <div class="admin-brand-mark">
                        HT
                    </div>
                @endif

                <div class="admin-brand-text">
                    <div class="admin-brand-title">
                        {{ $appSettings['site_name'] ?? 'HIMAPRO TI' }}
                    </div>

                    <div class="admin-brand-subtitle">
                        ADMIN PANEL
                    </div>
                </div>

            </div>

            <button
                type="button"
                class="sidebar-toggle-btn"
                onclick="toggleSidebar()"
                aria-label="Toggle Sidebar"
                title="Toggle Sidebar"
            >
                <i class="bi bi-list"></i>
            </button>

        </div>

    </div>


    {{-- NAVIGASI --}}
    <nav class="admin-nav">

        @php
            $user = auth()->user();
            $can = fn($permission) => $user && $user->hasPermission($permission);
        @endphp

        {{-- ==================== UTAMA ==================== --}}
        @if ($can('dashboard.view'))
            <div class="admin-nav-label">
                Utama
            </div>

            <a
                href="{{ route('admin.dashboard') }}"
                class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                title="Dashboard"
            >
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
        @endif


        {{-- ==================== ORGANISASI ==================== --}}
        @if ($can('pengurus.view') || $can('departemen.view') || $can('program-kerja.view'))
            <div class="admin-nav-label mt-3">
                Organisasi
            </div>
        @endif

        @if ($can('pengurus.view'))
            <a
                href="{{ route('admin.pengurus.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.pengurus.*') ? 'active' : '' }}"
                title="Pengurus"
            >
                <i class="bi bi-people-fill"></i>
                <span>Pengurus</span>
            </a>
        @endif

        @if ($can('departemen.view'))
            <a
                href="{{ route('admin.departemen.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.departemen.*') ? 'active' : '' }}"
                title="Departemen"
            >
                <i class="bi bi-diagram-3-fill"></i>
                <span>Departemen</span>
            </a>
        @endif

        @if ($can('program-kerja.view'))
            <a
                href="{{ route('admin.program-kerja.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.program-kerja.*') ? 'active' : '' }}"
                title="Program Kerja"
            >
                <i class="bi bi-kanban-fill"></i>
                <span>Program Kerja</span>
            </a>
        @endif


        {{-- ==================== KONTEN ==================== --}}
        @if ($can('agenda.view') || $can('pengumuman.view') || $can('gallery.view') || $can('partner.view'))
            <div class="admin-nav-label mt-3">
                Konten
            </div>
        @endif

        @if ($can('agenda.view'))
            <a
                href="{{ route('admin.agenda.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}"
                title="Agenda"
            >
                <i class="bi bi-calendar-event-fill"></i>
                <span>Agenda</span>
            </a>
        @endif

        @if ($can('pengumuman.view'))
            <a
                href="{{ route('admin.pengumuman.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}"
                title="Pengumuman"
            >
                <i class="bi bi-megaphone-fill"></i>
                <span>Pengumuman</span>
            </a>
        @endif

        @if ($can('gallery.view'))
            <a
                href="{{ route('admin.gallery.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.gallery.*') ? 'active' : '' }}"
                title="Gallery"
            >
                <i class="bi bi-images"></i>
                <span>Gallery</span>
            </a>
        @endif

        @if ($can('partner.view'))
            <a
                href="{{ route('admin.partner.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.partner.*') ? 'active' : '' }}"
                title="Partner"
            >
                <i class="bi bi-briefcase-fill"></i>
                <span>Partner</span>
            </a>
        @endif


        {{-- ==================== ADMINISTRASI ==================== --}}
        @if ($can('dokumen.view') || $can('notulensi.view') || $can('surat.view'))
            <div class="admin-nav-label mt-3">
                Administrasi
            </div>
        @endif

        @if ($can('dokumen.view'))
            <a
                href="{{ route('admin.dokumen.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.dokumen.*') ? 'active' : '' }}"
                title="Dokumen"
            >
                <i class="bi bi-folder-fill"></i>
                <span>Dokumen</span>
            </a>
        @endif

        @if ($can('notulensi.view'))
            <a
                href="{{ route('admin.notulensi.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.notulensi.*') ? 'active' : '' }}"
                title="Notulensi"
            >
                <i class="bi bi-journal-text"></i>
                <span>Notulensi</span>
            </a>
        @endif

        @if ($can('surat.view'))
            <a
                href="{{ route('admin.surat.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.surat.*') ? 'active' : '' }}"
                title="Surat"
            >
                <i class="bi bi-envelope-fill"></i>
                <span>Surat</span>
            </a>
        @endif


        {{-- ==================== KEUANGAN ==================== --}}
        @if ($can('anggaran.view') || $can('keuangan.view') || $can('laporan.view'))
            <div class="admin-nav-label mt-3">
                Keuangan
            </div>
        @endif

        @if ($can('anggaran.view'))
            <a
                href="{{ route('admin.anggaran.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.anggaran.*') ? 'active' : '' }}"
                title="Anggaran"
            >
                <i class="bi bi-cash-stack"></i>
                <span>Anggaran</span>
            </a>
        @endif

        @if ($can('keuangan.view'))
            <a
                href="{{ route('admin.keuangan.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.keuangan.*') ? 'active' : '' }}"
                title="Keuangan"
            >
                <i class="bi bi-wallet2"></i>
                <span>Keuangan</span>
            </a>
        @endif

        @if ($can('laporan.view'))
            <a
                href="{{ route('admin.laporan.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}"
                title="Laporan"
            >
                <i class="bi bi-file-earmark-bar-graph-fill"></i>
                <span>Laporan</span>
            </a>
        @endif


        {{-- ==================== KOMUNIKASI ==================== --}}
        @if ($can('pesan.view'))
            <div class="admin-nav-label mt-3">
                Komunikasi
            </div>

            <a
                href="{{ route('admin.pesan.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}"
                title="Pesan Masuk"
            >
                <i class="bi bi-chat-dots-fill"></i>
                <span>Pesan Masuk</span>

                @if (isset($unreadPesanCount) && $unreadPesanCount > 0)
                    <span class="admin-nav-badge">
                        {{ $unreadPesanCount > 99 ? '99+' : $unreadPesanCount }}
                    </span>
                @endif
            </a>
        @endif


        {{-- ==================== SISTEM ==================== --}}
        <div class="admin-nav-label mt-3">
            Sistem
        </div>

        <a
            href="{{ route('admin.profile.edit') }}"
            class="admin-nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}"
            title="Profil Saya"
        >
            <i class="bi bi-person-circle"></i>
            <span>Profil Saya</span>
        </a>

        @if ($can('user.view'))
            <a
                href="{{ route('admin.users.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                title="Manajemen User"
            >
                <i class="bi bi-person-badge-fill"></i>
                <span>Manajemen User</span>
            </a>
        @endif

        @if ($can('role.view'))
            <a
                href="{{ route('admin.roles.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                title="Manajemen Role"
            >
                <i class="bi bi-shield-lock-fill"></i>
                <span>Manajemen Role</span>
            </a>
        @endif

        @if ($can('settings.view'))
            <a
                href="{{ route('admin.landing-page.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.landing-page.*') ? 'active' : '' }}"
                title="Landing Page"
            >
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>Landing Page</span>
            </a>
        @endif

        @if ($can('settings.view'))
            <a
                href="{{ route('admin.settings.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                title="Pengaturan"
            >
                <i class="bi bi-gear-fill"></i>
                <span>Pengaturan</span>
            </a>
        @endif

        @if ($can('settings.update'))
            <a
                href="{{ route('admin.backup.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.backup.*') ? 'active' : '' }}"
                title="Backup Database"
            >
                <i class="bi bi-cloud-arrow-down-fill"></i>
                <span>Backup Database</span>
            </a>
        @endif

        @if ($can('activity-log.view'))
            <a
                href="{{ route('admin.activity-logs.index') }}"
                class="admin-nav-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}"
                title="Activity Log"
            >
                <i class="bi bi-clock-history"></i>
                <span>Activity Log</span>
            </a>
        @endif

        @if (Route::has('home'))
            <a
                href="{{ route('home') }}"
                target="_blank"
                class="admin-nav-link"
                title="Lihat Website"
            >
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Lihat Website</span>
            </a>
        @endif

        <form
            action="{{ route('admin.logout') }}"
            method="POST"
            class="mt-2"
        >
            @csrf

            <button
                type="submit"
                class="admin-nav-link"
                title="Logout"
            >
                <i class="bi bi-box-arrow-right"></i>
                <span>Logout</span>
            </button>
        </form>

    </nav>

</aside>