<header class="admin-navbar">

    {{-- LEFT: HAMBURGER + SEARCH --}}
    <div class="admin-navbar-left">

        {{-- HAMBURGER (mobile only) --}}
        <button
            type="button"
            class="admin-navbar-menu"
            onclick="toggleSidebar()"
            aria-label="Toggle Menu"
        >
            <i class="bi bi-list"></i>
        </button>

        {{-- SEARCH --}}
        <div class="admin-navbar-search">
            @include('partials.admin.search')
        </div>

    </div>


    {{-- RIGHT: NOTIFICATION + USER --}}
    <div class="admin-navbar-right">

        {{-- NOTIFICATION (Pesan) --}}
        @if (auth()->user()->hasPermission('pesan.view'))
            <a
                href="{{ route('admin.pesan.index', ['status' => 'unread']) }}"
                class="admin-navbar-icon-btn"
                title="Pesan Belum Dibaca"
            >
                <i class="bi bi-bell-fill"></i>

                @if (isset($unreadPesanCount) && $unreadPesanCount > 0)
                    <span class="admin-navbar-icon-badge">
                        {{ $unreadPesanCount > 99 ? '99+' : $unreadPesanCount }}
                    </span>
                @endif
            </a>
        @endif


        {{-- USER --}}
        @auth
            <a href="{{ route('admin.profile.edit') }}" class="admin-user" title="Profil Saya">

                <div class="text-end admin-user-text">
                    <div class="admin-user-name">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="admin-user-role">
                        {{ auth()->user()->role?->name ?? 'User' }}
                    </div>
                </div>

                @if (auth()->user()->avatar)
                    <img
                        src="{{ asset('storage/' . auth()->user()->avatar) }}"
                        alt="{{ auth()->user()->name }}"
                        class="admin-user-avatar"
                        style="object-fit: cover;"
                    >
                @else
                    <div class="admin-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif

            </a>
        @endauth

    </div>

</header>