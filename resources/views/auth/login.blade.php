<!DOCTYPE html>
<html>

<head>
    <title>Login - Marketing Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
            height: 100vh;
            display: flex;
            margin: 0;
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

        .logo-circle {
            width: 50px;
            height: 50px;
            background: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .left-panel p {
            color: #9ca3af;
        }

        .right-panel {
            width: 60%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 480px;
            background: white;
            padding: 45px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.06);
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
            transition: 0.2s;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
        }

        .btn-login {
            background-color: #2563eb;
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-weight: 500;
            transition: 0.2s;
        }

        .btn-login:hover {
            background-color: #1e40af;
            transform: translateY(-1px);
        }

        .logo-wrapper img {
            max-width: 160px;
            height: auto;
            margin-bottom: 25px;
        }
    </style>
</head>

<body>

    <!-- Left Branding -->
    <div class="left-panel">
        <div class="logo-wrapper">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Perusahaan">
        </div>

        <h2>Marketing Dashboard</h2>
        <p>Kelola prospek, pipeline, dan revenue dalam satu sistem terintegrasi.</p>
    </div>

    <!-- Right Login -->
    <div class="right-panel">
        <div class="login-card">

            <h5 class="mb-4 fw-semibold">Login Akun</h5>

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button class="btn btn-login w-100 text-white">
                    Masuk
                </button>
            </form>

        </div>
    </div>

</body>

</html>
