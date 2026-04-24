<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ALMEDIS</title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* ── 1. SOLUSI MATA HITAM BAWAAN BROWSER ── */
        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }

        input::-webkit-contacts-auto-fill-button,
        input::-webkit-credentials-auto-fill-button {
            visibility: hidden;
            display: none !important;
            pointer-events: none;
        }

        body {
            font-family: 'Manrope', sans-serif;
            min-height: 100vh;
            background: #f0f4ff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #111827;
        }

        /* ── WRAPPER ── */
        .login-wrapper {
            display: flex;
            width: 100%;
            max-width: 1000px;
            min-height: 650px;
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px -12px rgba(6, 21, 74, 0.15);
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            flex: 1.1;
            background: #06154a;
            display: flex;
            flex-direction: column;
            padding: 50px;
            position: relative;
            overflow: hidden;
        }

        .left-panel .grid-bg {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 32px 32px;
        }

        .left-panel .glow {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(63,114,255,0.15) 0%, transparent 70%);
            bottom: -150px;
            right: -100px;
        }

        .logo-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 60px;
            position: relative;
            z-index: 1;
        }

        .logo-box {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #3f72ff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-name {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            letter-spacing: 3px;
        }

        .left-main {
            position: relative;
            z-index: 1;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-headline {
            font-size: 36px;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .left-headline span { color: #7b9fff; }

        .left-sub {
            font-size: 15px;
            color: rgba(255,255,255,0.5);
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 320px;
        }

        .features {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .feature-ico {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(63,114,255,0.15);
            border: 1px solid rgba(63,114,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-title {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
        }

        .left-footer {
            position: relative;
            z-index: 1;
            margin-top: 40px;
            display: flex;
            align-items: center;
            gap: 8px;
            opacity: 0.4;
        }

        .status-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: #00e676;
            box-shadow: 0 0 10px #00e676;
        }

        .left-footer span { font-size: 11px; color: #fff; font-weight: 500; }

        /* ── RIGHT PANEL ── */
        .right-panel {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #f0f4ff;
            color: #3f72ff;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            padding: 6px 14px;
            border-radius: 100px;
            margin-bottom: 24px;
            width: fit-content;
        }

        .form-title {
            font-size: 32px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 12px;
            letter-spacing: -1px;
        }

        .form-title span { color: #3f72ff; }

        .form-caption {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 40px;
        }

        /* Form Inputs */
        .form-group { margin-bottom: 20px; }
        .form-group label {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .input-wrap { position: relative; }
        .input-wrap .icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #3f72ff;
            opacity: 0.5;
            display: flex;
            z-index: 2;
        }

        .input-wrap input {
            width: 100%;
            padding: 14px 44px 14px 44px; /* Padding kanan ditambah agar teks tidak menabrak icon mata */
            border: 2px solid #f3f4f6;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Manrope', sans-serif;
            background: #f9fafb;
            transition: all 0.2s;
        }

        .input-wrap input:focus {
            outline: none;
            border-color: #3f72ff;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(63,114,255,0.05);
        }

        /* Tombol Mata Custom */
        .toggle-pw {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            z-index: 10; /* Pastikan di atas segalanya */
            padding: 5px;
        }
        .toggle-pw:hover { color: #3f72ff; }
        .hidden { display: none; }

        /* Buttons */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: #06154a;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            margin: 10px 0 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-family: 'Manrope', sans-serif;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            background: #0f236b;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(6, 21, 74, 0.15);
        }

        .divider {
            display: flex; align-items: center; gap: 15px;
            margin-bottom: 24px;
        }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #f3f4f6; }
        .divider span { font-size: 10px; color: #9ca3af; font-weight: 800; letter-spacing: 1px; }

        .btn-back {
            width: 100%;
            padding: 14px;
            border: 2px solid #f3f4f6;
            border-radius: 12px;
            color: #6b7280;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            transition: all 0.2s;
        }

        .btn-back:hover { background: #f9fafb; border-color: #e5e7eb; color: #111827; }

        @media (max-width: 850px) {
            .left-panel { display: none; }
            .login-wrapper { max-width: 480px; }
            .right-panel { padding: 40px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <div class="left-panel">
        <div class="grid-bg"></div>
        <div class="glow"></div>

        <div class="logo-row">
            <div class="logo-box">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                </svg>
            </div>
            <span class="brand-name">ALMEDIS</span>
        </div>

        <div class="left-main">
            <h2 class="left-headline">Kelola alat<br>medis <span>lebih<br>profesional.</span></h2>
            <p class="left-sub">Sistem terintegrasi untuk efisiensi fasilitas kesehatan Anda.</p>

            <div class="features">
                <div class="feature">
                    <div class="feature-ico">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7b9fff" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    </div>
                    <div class="feature-title">Monitoring Real-time</div>
                </div>
                <div class="feature">
                    <div class="feature-ico">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7b9fff" stroke-width="2.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <div class="feature-title">Inventaris Terpusat</div>
                </div>
            </div>
        </div>

        <div class="left-footer">
            <div class="status-dot"></div>
            <span>Sistem Operasional Normal</span>
        </div>
    </div>

    <div class="right-panel">
        <div class="badge">
            <svg width="6" height="6" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4" fill="#3f72ff"/></svg>
            Portal Pengguna
        </div>

        <h1 class="form-title">Selamat <span>Datang</span></h1>
        <p class="form-caption">Gunakan akun terdaftar Anda untuk melanjutkan.</p>

        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Alamat Email</label>
                <div class="input-wrap">
                    <span class="icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </span>
                    <input type="email" name="email" placeholder="nama@gmail.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label>Kata Sandi</label>
                <div class="input-wrap">
                    <span class="icon">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </span>
                    <input type="password" id="password" name="password" placeholder="••••••••" required>

                    <button type="button" class="toggle-pw" onclick="togglePassword()">
                        <svg id="eyeOpen" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg id="eyeClosed" class="hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-10-7-10-7a22.71 22.71 0 0 1 3.87-4.87"></path><path d="M1 1l22 22"></path><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"></path></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Masuk ke Dashboard
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </button>
        </form>

        <div class="divider"><span>ATAU</span></div>

        <a href="{{ url('/') }}" class="btn-back">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Kembali ke Beranda
        </a>
    </div>
</div>

<script>
    function togglePassword() {
        const pwInput = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        if (pwInput.type === 'password') {
            pwInput.type = 'text';
            eyeOpen.classList.add('hidden');
            eyeClosed.classList.remove('hidden');
        } else {
            pwInput.type = 'password';
            eyeOpen.classList.remove('hidden');
            eyeClosed.classList.add('hidden');
        }
    }
</script>

</body>
</html>
