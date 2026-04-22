<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Arsa Workspace</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at center, #1e293b 0%, #0f172a 100%);
            color: #f1f5f9;
            position: relative;
            overflow: hidden;
            transition: all 0.5s ease;
        }

        /* Ambient Background Blobs */
        .ambient-blob {
            position: absolute;
            width: 80vw;
            height: 80vw;
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .blob-1 {
            top: -30%;
            left: -10%;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, rgba(15, 23, 42, 0) 70%);
        }
        .blob-2 {
            bottom: -20%;
            right: -10%;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.08) 0%, rgba(15, 23, 42, 0) 70%);
        }

        /* Data Stream Overlay */
        .data-stream {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: linear-gradient(0deg, transparent 24%, rgba(59, 130, 246, 0.03) 25%, rgba(59, 130, 246, 0.03) 26%, transparent 27%, transparent 74%, rgba(59, 130, 246, 0.03) 75%, rgba(59, 130, 246, 0.03) 76%, transparent 77%, transparent), linear-gradient(90deg, transparent 24%, rgba(59, 130, 246, 0.03) 25%, rgba(59, 130, 246, 0.03) 26%, transparent 27%, transparent 74%, rgba(59, 130, 246, 0.03) 75%, rgba(59, 130, 246, 0.03) 76%, transparent 77%, transparent);
            background-size: 50px 50px;
            opacity: 0.5;
            z-index: 1;
            transition: opacity 0.5s ease;
        }

        .login-wrapper {
            width: 100%;
            max-width: 460px;
            padding: 20px;
            z-index: 5;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 35px;
            transition: all 0.5s ease;
        }

        .logo-container img {
            max-width: 160px;
            height: auto;
            filter: drop-shadow(0 0 10px rgba(59, 130, 246, 0.3));
        }

        /* Glassmorphism Login Card */
        .login-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            padding: 50px 45px;
            border-radius: 28px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
            transition: opacity 0.3s ease;
        }

        .login-header h3 { font-weight: 700; color: #ffffff; margin-bottom: 10px; letter-spacing: -1px; }
        .login-header p { color: #94a3b8; font-size: 1rem; margin: 0; }

        .form-label { font-weight: 600; color: #e2e8f0; font-size: 0.9rem; margin-bottom: 10px; }
        
        .input-group-custom { position: relative; }

        .form-control {
            background-color: rgba(15, 23, 42, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 16px;
            border-radius: 14px;
            font-size: 1rem;
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .form-control::placeholder { color: #64748b; }

        .form-control:focus {
            background-color: rgba(15, 23, 42, 0.8);
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
            outline: none;
            color: #ffffff;
        }

        .password-toggle {
            position: absolute;
            right: 18px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #64748b;
            cursor: pointer;
            padding: 0;
            transition: color 0.2s;
            z-index: 5;
        }
        .password-toggle:hover { color: #3b82f6; }

        .btn-login {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff !important;
            border: none;
            border-radius: 14px;
            padding: 16px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(37, 99, 235, 0.3);
        }

        .footer-text {
            text-align: center;
            margin-top: 35px;
            font-size: 0.85rem;
            color: #64748b;
            transition: opacity 0.3s ease;
        }

        .alert-custom {
            background-color: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border-radius: 14px;
            padding: 14px 18px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            margin-bottom: 30px;
        }

        /* ================= ANIMASI TRANSISI LOGIN (SUBMITTING STATE) ================= */
        body.form-submitting .login-card {
            transform: scale(0.96); /* Card mengecil perlahan */
            border-color: rgba(59, 130, 246, 0.4);
            box-shadow: 0 0 60px rgba(59, 130, 246, 0.2);
            pointer-events: none; /* Mencegah user klik dua kali */
        }

        body.form-submitting .login-header,
        body.form-submitting .form-label,
        body.form-submitting .form-control,
        body.form-submitting .password-toggle,
        body.form-submitting .footer-text {
            opacity: 0.4; /* Elemen form memudar perlahan */
        }

        body.form-submitting .btn-login {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%); /* Tombol berubah jadi warna Emerald Green */
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.4);
            transform: scale(1.02);
            letter-spacing: 2px;
        }

        body.form-submitting .ambient-blob {
            animation: pulse-fast 0.8s infinite alternate ease-in-out;
        }

        @keyframes pulse-fast {
            0% { transform: scale(1); opacity: 0.8; filter: brightness(1); }
            100% { transform: scale(1.3); opacity: 1; filter: brightness(1.5); }
        }
        /* ============================================================================== */

        @media (max-width: 576px) {
            .login-card { padding: 35px 25px; border-radius: 24px; }
            .ambient-blob { display: none; }
        }
    </style>
</head>

<body>

    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>
    <div class="data-stream"></div>

    <div class="login-wrapper">
        <div class="logo-container">
            <img src="{{ asset('assets/img/arsa/arsa_logo_white.png') }}" alt="Logo Arsa">
        </div>

        <div class="login-card">
            <div class="login-header">
                <h3>Arsa Workspace</h3>
                <p>Silakan masuk ke ekosistem digital Anda</p>
            </div>

            @if (session('error'))
                <div class="alert-custom">
                    <i class="fas fa-exclamation-circle me-2 fs-6"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form id="loginForm" method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="mb-4">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@arsatraining.com" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label">Kata Sandi</label>
                    <div class="input-group-custom">
                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()" title="Lihat Kata Sandi">
                            <i class="far fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-login shadow" id="btnSubmit">
                    Masuk ke Sistem
                </button>
            </form>
        </div>

        <div class="footer-text">
            &copy; 2026 PT Arsa Jaya Prima. All rights reserved.<br>
            Solusi Terintegrasi untuk Operasional dan Pertumbuhan.
        </div>
    </div>

    <script>
        // Fitur Lihat Password
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Fitur Animasi Transisi Saat Login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            // Kita tidak melakukan e.preventDefault(), biarkan form tetap disubmit ke server.
            
            // Tambahkan class form-submitting ke body untuk memicu semua animasi CSS
            document.body.classList.add('form-submitting');
            
            // Ubah teks tombol dan tambahkan icon loading berputar
            const btn = document.getElementById('btnSubmit');
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin me-2"></i> MENGOTENTIKASI...';
            
            // Opsional: blur out sedikit logo
            document.querySelector('.logo-container').style.opacity = '0.5';
        });
    </script>
</body>
</html>