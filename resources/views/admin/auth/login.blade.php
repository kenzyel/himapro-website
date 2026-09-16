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

    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        /* =========================================================
           RESET & BASE
           ========================================================= */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

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

        @property --a {
            syntax: '<angle>';
            inherits: false;
            initial-value: 0deg;
        }

        @property --b {
            syntax: '<angle>';
            inherits: false;
            initial-value: 0deg;
        }

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

        /* =========================================================
           ANIMATED BACKGROUND
           ========================================================= */
        body::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(circle at 20% 30%, rgba(255, 210, 26, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(245, 169, 0, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(255, 210, 26, 0.05) 0%, transparent 50%);
            animation: bgMove 20s ease-in-out infinite;
            z-index: 0;
            pointer-events: none;
        }

        @keyframes bgMove {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            50%      { transform: translate(-50px, -50px) rotate(180deg); }
        }

        /* =========================================================
           PARTICLES
           ========================================================= */
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            animation: float 15s infinite linear;
        }

        @keyframes float {
            0%   { transform: translateY(100vh) scale(0); opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 1; }
            100% { transform: translateY(-100vh) scale(1); opacity: 0; }
        }

        /* =========================================================
           WRAPPER
           ========================================================= */
        .login-wrapper {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
            animation: fadeInUp .7s ease-out;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* =========================================================
           BRAND
           ========================================================= */
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
            0%, 100% {
                box-shadow:
                    0 0 0 1px rgba(255,210,26,.3),
                    0 8px 40px rgba(255,210,26,.35);
            }
            50% {
                box-shadow:
                    0 0 0 1px rgba(255,210,26,.5),
                    0 8px 60px rgba(255,210,26,.5);
            }
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

        /* =========================================================
           NEON CARD — BORDER BERPUTAR
           ========================================================= */
        .card-wrapper {
            position: relative;
            padding: 3px;
            border-radius: 24px;
            background: repeating-conic-gradient(
                from var(--a),
                #FFD21A 0%,
                #FFD21A 5%,
                transparent 5%,
                transparent 40%,
                #FFD21A 50%
            );
            animation: rotate-a 6s linear infinite;
            transition: transform 0.3s ease;
        }

        .card-wrapper:hover {
            transform: translateY(-4px);
        }

        @keyframes rotate-a {
            from { --a: 0deg; }
            to   { --a: 360deg; }
        }

        /* Border kedua (gold gelap, rotasi terbalik) */
        .card-wrapper::before {
            content: '';
            position: absolute;
            inset: 0;
            padding: 3px;
            border-radius: 24px;

            background: repeating-conic-gradient(
                from calc(var(--b) + 180deg),
                #F5A900 0%,
                #F5A900 5%,
                transparent 5%,
                transparent 40%,
                #F5A900 50%
            );

            -webkit-mask:
                linear-gradient(#000 0 0) content-box,
                linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;

            animation: rotate-b 9s linear infinite;
            pointer-events: none;
            filter: blur(0.5px);
        }

        @keyframes rotate-b {
            from { --b: 0deg; }
            to   { --b: 360deg; }
        }

        /* Glow ambient di belakang card */
        .card-wrapper::after {
            content: '';
            position: absolute;
            inset: -20px;
            border-radius: 32px;
            background: radial-gradient(
                ellipse,
                rgba(255, 210, 26, 0.12),
                transparent 70%
            );
            z-index: -1;
            pointer-events: none;
            animation: pulseGlowSoft 4s ease-in-out infinite;
        }

        @keyframes pulseGlowSoft {
            0%, 100% { opacity: 0.6; }
            50%      { opacity: 1; }
        }

        /* =========================================================
           CARD (ISI)
           ========================================================= */
        .card {
            padding: 36px 32px;
            border-radius: 21px;
            background: linear-gradient(145deg, #1D1D20, #141416);
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
            box-shadow: 0 0 20px var(--primary);
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

        /* =========================================================
           FORM
           ========================================================= */
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

        /* =========================================================
           ERROR
           ========================================================= */
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

        /* =========================================================
           FOOTER
           ========================================================= */
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

        /* =========================================================
           RESPONSIVE
           ========================================================= */
        @media (max-width: 480px) {
            .card {
                padding: 28px 22px;
            }
            .brand h1 {
                font-size: 20px;
            }
        }
    </style>

</head>

<body>

    {{-- Particles Background --}}
    <div class="particles" id="particles"></div>

    {{-- Login Wrapper --}}
    <main class="login-wrapper">

        {{-- Brand --}}
        <div class="brand">
            <div class="brand-mark">HT</div>
            <h1>HIMAPRO TI SAKTI</h1>
            <p>Sistem Informasi Organisasi</p>
        </div>

        {{-- Card dengan Border Neon --}}
        <div class="card-wrapper">
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
        </div>

        {{-- Footer --}}
        <div class="footer">
            &copy; {{ date('Y') }} <strong>HIMAPRO TI SAKTI</strong>
        </div>

    </main>

    {{-- Particles Script --}}
    <script>
        (function () {
            const particlesContainer = document.getElementById('particles');
            if (!particlesContainer) return;

            const particleCount = 50;
            const colors = [
                'rgba(255, 210, 26, 0.6)',
                'rgba(245, 169, 0, 0.6)',
                'rgba(245, 243, 232, 0.5)'
            ];

            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';

                particle.style.left = Math.random() * 100 + '%';
                particle.style.top = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (Math.random() * 10 + 10) + 's';

                const size = Math.random() * 3 + 1;
                particle.style.width = size + 'px';
                particle.style.height = size + 'px';

                particle.style.background = colors[Math.floor(Math.random() * colors.length)];
                particle.style.boxShadow = `0 0 ${size * 3}px currentColor`;

                particlesContainer.appendChild(particle);
            }
        })();
    </script>

</body>

</html>