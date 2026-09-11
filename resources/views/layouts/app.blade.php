<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    {{-- Favicon --}}
    @if (! empty($appSettings['site_favicon']))
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $appSettings['site_favicon']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <title>
        @yield('title', 'Beranda')
        — {{ $appSettings['site_name'] ?? 'HIMAPRO TI SAKTI' }}
    </title>

    {{-- SEO --}}
    <meta
        name="description"
        content="@yield('meta_description', $appSettings['site_description'] ?? 'Himpunan Mahasiswa Program Studi Teknologi Informasi SAKTI — Wadah pengembangan potensi, kolaborasi, dan kontribusi mahasiswa.')"
    >

    <meta
        name="keywords"
        content="@yield('meta_keywords', $appSettings['seo_keywords'] ?? 'himapro, teknologi informasi, sakti, himpunan mahasiswa')"
    >

    <meta
        name="author"
        content="{{ $appSettings['seo_author'] ?? 'HIMAPRO TI SAKTI' }}"
    >

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Beranda') — {{ $appSettings['site_name'] ?? 'HIMAPRO TI SAKTI' }}">
    <meta property="og:description" content="@yield('meta_description', $appSettings['site_description'] ?? 'Himpunan Mahasiswa Program Studi Teknologi Informasi SAKTI.')">
    <meta property="og:site_name" content="{{ $appSettings['site_name'] ?? 'HIMAPRO TI SAKTI' }}">

    {{-- CSRF --}}
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    {{-- Preload Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    {{-- Vite --}}
    @vite([
        'resources/css/app.css',
        'resources/css/frontend.css',
        'resources/js/app.js'
    ])

    @stack('styles')

</head>

<body class="fe-body">

    @include('partials.frontend.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.frontend.footer')

    @stack('scripts')

</body>

</html>