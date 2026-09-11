<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>403 — Akses Ditolak</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet"
    >

    <style>
        :root {
            --bg: #0B0B0D;
            --section: #141416;
            --card: #1D1D20;
            --primary: #FFD21A;
            --secondary: #F5A900;
            --text: #F5F3E8;
            --muted: #929298;
            --border: rgba(255, 255, 255, 0.08);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: var(--bg);
            color: var(--text);
            font-family: 'Inter', sans-serif;
            overflow: hidden;
            position: relative;
        }

        /* Background orbs */
        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.15;
            pointer-events: none;
            z-index: 0;
        }

        body::before {
            top: -200px;
            left: -200px;
            width: 500px;
            height: 500px;
            background: var(--primary);
            animation: float 18s ease-in-out infinite;
        }

        body::after {
            bottom: -200px;
            right: -200px;
            width: 500px;
            height: 500px;
            background: var(--secondary);
            animation: float 22s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50%      { transform: translate(40px, -30px) scale(1.1); }
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 520px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .lock-icon {
            width: 120px;
            height: 120px;
            margin: 0 auto 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 32px;
            background: linear-gradient(135deg, rgba(255, 210, 26, 0.15), rgba(245, 169, 0, 0.05));
            border: 1px solid rgba(255, 210, 26, 0.25);
            color: var(--primary);
            font-size: 56px;
            box-shadow:
                0 0 0 8px rgba(255, 210, 26, 0.04),
                0 20px 60px rgba(255, 210, 26, 0.15);
            animation: pulseGlow 3s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% {
                box-shadow:
                    0 0 0 8px rgba(255, 210, 26, 0.04),
                    0 20px 60px rgba(255, 210, 26, 0.15);
            }
            50% {
                box-shadow:
                    0 0 0 16px rgba(255, 210, 26, 0.02),
                    0 20px 80px rgba(255, 210, 26, 0.3);
            }
        }

        .code {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 999px;
            background: rgba(255, 210, 26, 0.1);
            border: 1px solid rgba(255, 210, 26, 0.25);
            color: var(--primary);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 42px;
            font-weight: 900;
            letter-spacing: -0.03em;
            line-height: 1.1;
            margin-bottom: 16px;
        }

        h1 .accent {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        p {
            font-size: 15px;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 36px;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            padding: 14px 26px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.25s ease;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--primary);
            color: #111;
            box-shadow: 0 6px 24px rgba(255, 210, 26, 0.3);
        }

        .btn-primary:hover {
            background: var(--secondary);
            transform: translateY(-2px);
            box-shadow: 0 10px 32px rgba(255, 210, 26, 0.45);
            color: #111;
        }

        .btn-outline {
            background: transparent;
            color: var(--text);
            border-color: rgba(255, 255, 255, 0.14);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .hint {
            margin-top: 36px;
            font-size: 12.5px;
            color: #55555c;
            letter-spacing: 0.02em;
        }

        @media (max-width: 575.98px) {
            h1 { font-size: 30px; }
            p { font-size: 14px; }
            .lock-icon {
                width: 100px;
                height: 100px;
                font-size: 44px;
                border-radius: 26px;
            }
        }
    </style>

</head>

<body>

    <div class="container">

        <div class="lock-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <div class="code">403 Forbidden</div>

        <h1>
            Akses <span class="accent">Ditolak</span>
        </h1>

        <p>
            Anda tidak memiliki izin untuk mengakses halaman ini.
            Silakan hubungi administrator jika Anda merasa ini kesalahan.
        </p>

        <div class="actions">

            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                    <i class="bi bi-grid-1x2-fill"></i>
                    Kembali ke Dashboard
                </a>
            @else
                <a href="{{ route('home') }}" class="btn btn-primary">
                    <i class="bi bi-house-fill"></i>
                    Kembali ke Beranda
                </a>
            @endauth

            <a href="javascript:history.back()" class="btn btn-outline">
                <i class="bi bi-arrow-left"></i>
                Halaman Sebelumnya
            </a>

        </div>

        <div class="hint">
            HIMAPRO TI SAKTI — Sistem Informasi Organisasi
        </div>

    </div>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

</body>

</html>