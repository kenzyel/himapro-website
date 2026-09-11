<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Admin — HIMAPRO TI SAKTI</title>

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
            --border: rgba(255,255,255,.08);
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

        /* Animated background orbs */
        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: .18;
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

        .login-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
            animation: fadeInUp .7s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .brand {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-mark {
            width: 68px;
            height: 68px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #111;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -0.5px;
            box-shadow:
                0 0 0 1px rgba(255,210,26,.3),
                0 8px 40px rgba(255,210,26,.35);
            animation: pulseGlow 3s ease-in-out infinite;
        }

        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 0 1px rgba(255,210,26,.3), 0 8px 40px rgba(255,210,26,.35); }
            50%      { box-shadow: 0 0 0 1px rgba(255,210,26,.5), 0 8px 60px rgba(255,210,26,.5); }
        }

        .brand h1 {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .brand p {
            margin-top: 8px;
            color: var(--muted);
            font-size: 13px;
            letter-spacing: 0.02em;
        }

        .card {
            padding: 36px 32px;
            border: 1px solid var(--border);
            border-radius: 22px;
            background: rgba(20, 20, 22, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow:
                0 1px 2px rgba(0,0,0,.4),
                0 24px 80px rgba(0,0,0,.5),
                inset 0 1px 0 rgba(255,255,255,.04);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 20%;
            right: 20%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .card h2 {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 6px;
            letter-spacing: -0.01em;
        }

        .card-description {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 28px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 12.5px;
            font-weight: 700;
            letter-spacing: 0.01em;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 13px 15px;
            border: 1px solid var(--border);
            border-radius: 11px;
            outline: none;
            background: rgba(11, 11, 13, 0.6);
            color: var(--text);
            font-size: 14px;
            font-family: inherit;
            transition: all .25s ease;
        }

        input::placeholder {
            color: #55555c;
        }

        input:focus {
            border-color: var(--primary);
            background: rgba(11, 11, 13, 0.9);
            box-shadow: 0 0 0 4px rgba(255, 210, 26, .12);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 22px;
            color: var(--muted);
            font-size: 13px;
            cursor: pointer;
            user-select: none;
        }

        .remember input {
            width: 16px;
            height: 16px;
            accent-color: var(--primary);
            cursor: pointer;
        }

        .button {
            width: 100%;
            padding: 14px 18px;
            border: 0;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: #111;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.02em;
            cursor: pointer;
            font-family: inherit;
            position: relative;
            overflow: hidden;
            transition: all .25s ease;
            box-shadow: 0 4px 20px rgba(255, 210, 26, .3);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(255, 210, 26, .45);
        }

        .button:active {
            transform: translateY(0);
        }

        .button::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, transparent, rgba(255,255,255,.3), transparent);
            transform: translateX(-100%);
            transition: transform .6s ease;
        }

        .button:hover::after {
            transform: translateX(100%);
        }

        .error {
            margin-bottom: 22px;
            padding: 13px 16px;
            border: 1px solid rgba(239,68,68,.35);
            border-radius: 11px;
            background: rgba(239,68,68,.08);
            color: #fca5a5;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shake .4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25%      { transform: translateX(-6px); }
            75%      { transform: translateX(6px); }
        }

        .error::before {
            content: '⚠';
            font-size: 15px;
        }

        .footer {
            margin-top: 26px;
            text-align: center;
            color: #55555c;
            font-size: 11.5px;
            letter-spacing: 0.03em;
        }

        .footer strong {
            color: var(--primary);
            font-weight: 700;
        }
    </style>
</head>

<body>
    <main class="login-wrapper">

        <div class="brand">
            <div class="brand-mark">HT</div>
            <h1>HIMAPRO TI SAKTI</h1>
            <p>Sistem Informasi Organisasi</p>
        </div>

        <div class="card">

            <h2>Masuk ke Admin</h2>

            <p class="card-description">
                Gunakan akun pengurus yang telah terdaftar.
            </p>

            @if ($errors->any())
                <div class="error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <label class="remember">
                    <input type="checkbox" name="remember" value="1">
                    Ingat saya
                </label>

                <button type="submit" class="button">
                    Masuk →
                </button>
            </form>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} <strong>HIMAPRO TI SAKTI</strong>
        </div>

    </main>
</body>
</html>