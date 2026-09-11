<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=5.0"
    >

    {{-- Favicon --}}
    @if (! empty($appSettings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $appSettings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <title>
        @yield('title', 'Dashboard')
        — {{ $appSettings['site_name'] ?? 'HIMAPRO TI SAKTI' }}
    </title>

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    @stack('styles')

</head>

<body class="preload">

<div class="admin-wrapper">

    {{-- SIDEBAR OVERLAY (mobile) --}}
    <div class="admin-sidebar-overlay" id="adminSidebarOverlay" onclick="closeSidebar()"></div>

    @include('partials.admin.sidebar')

    <main class="admin-main">

        @include('partials.admin.navbar')

        <div class="admin-content">

            @include('partials.admin.alerts')

            @yield('content')

        </div>

    </main>

</div>

@stack('scripts')

</body>

</html>