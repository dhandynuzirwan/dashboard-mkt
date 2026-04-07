<!DOCTYPE html>
<html>

<head>
    <title>Login - Marketing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            min-height: 100vh;
            display: flex;
            margin: 0;
            flex-direction: row; /* Desktop default */
        }

        .left-panel {
            width: 40%;
            background: linear-gradient(180deg, #111827, #1f2937);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }

        .left-panel::after {
            content: "";
            position: absolute;
            width: 300px;
            height: 300px;
            background: #2563eb;
            opacity: 0.08;
            border-radius: 50%;
            top: -80px;
            right: -80px;
        }

        .logo-wrapper img {
            max-width: 160px;
            height: auto;
            margin-bottom: 25px;
        }

        .right-panel {
            width: 60%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 480px; /* Limit agar tidak terlalu lebar di desktop */
            background: white;
            padding: 45px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            transition: 0.2s;
        }

        .btn-login {
            background-color: #2563eb;
            color: #ffffff !important; /* Paksa teks tetap putih */
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
        }

        .btn-login:hover {
            background-color: #1e40af; /* Biru yang lebih gelap */
            color: #ffffff !important; /* Pastikan teks TIDAK berubah warna */
            transform: translateY(-2px); /* Efek angkat sedikit */
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* --- RESPONSIVE BREAKPOINT --- */
        @media (max-width: 991.98px) {
            body {
                flex-direction: column; /* Stack vertikal di HP/Tablet */
            }

            .left-panel {
                width: 100%;
                padding: 40px 20px;
                text-align: center;
                align-items: center;
                min-height: auto;
            }

            .right-panel {
                width: 100%;
                padding: 40px 15px;
            }

            .login-card {
                padding: 30px 20px;
                box-shadow: none; /* Opsional: hilangkan shadow agar lebih flat di mobile */
                border: 1px solid #e2e8f0;
            }
            
            .left-panel p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>

    <div class="left-panel">
        <div class="logo-wrapper">
            <img src="{{ asset('assets/img/arsa/arsa_logo_white.png')}}" alt="Logo Arsa">
        </div>
        <h2 class="fw-bold">Marketing Dashboard</h2>
        <p class="text-secondary">Kelola prospek, pipeline, dan revenue dalam satu sistem terintegrasi.</p>
    </div>

    <div class="right-panel">
        <div class="login-card">
            <h5 class="mb-4 fw-bold text-dark">Login Akun</h5>

            @if (session('error'))
                <div class="alert alert-danger py-2 small">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label small fw-medium">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="nama@email.com" required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label small fw-medium">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="" required>
                </div>

                <button class="btn btn-login w-100 text-white shadow-sm">
                    Masuk ke Dashboard
                </button>
                
                <p class="text-center mt-4 small text-muted">
                    &copy; 2026 PT Arsa Jaya Prima
                </p>
            </form>
        </div>
    </div>

</body>

</html>