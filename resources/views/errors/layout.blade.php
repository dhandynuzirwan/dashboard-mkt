<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Arsa System</title>
    {{-- Menggunakan Bootstrap 5 CDN untuk Standalone --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            overflow: hidden;
        }
        .error-wrapper {
            max-width: 480px;
            width: 90%;
            text-align: center;
            background: #ffffff;
            padding: 50px 40px;
            border-radius: 24px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.04);
            position: relative;
        }
        .error-bg-code {
            font-size: 120px;
            font-weight: 900;
            color: #f1f3f5;
            position: absolute;
            top: 10%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 0;
            letter-spacing: 5px;
            line-height: 1;
            user-select: none;
        }
        .error-content {
            position: relative;
            z-index: 1;
            margin-top: 30px;
        }
        .error-icon {
            width: 80px;
            height: 80px;
            background: @yield('icon-bg', '#e7f1ff');
            color: @yield('icon-color', '#0d6efd');
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 35px;
            margin: 0 auto 25px auto;
            animation: float 3s ease-in-out infinite;
        }
        .error-title {
            font-weight: 800;
            color: #2b3445;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .error-desc {
            color: #6c757d;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .btn-back {
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body>

    <div class="error-wrapper">
        <div class="error-bg-code">@yield('code')</div>
        <div class="error-content">
            <div class="error-icon">
                <i class="@yield('icon', 'fas fa-exclamation-triangle')"></i>
            </div>
            <h1 class="error-title">@yield('heading')</h1>
            <p class="error-desc">@yield('message')</p>
            
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : url('/') }}" class="btn btn-@yield('btn-color', 'primary') btn-back">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Halaman Sebelumnya
            </a>
            
            <div class="mt-4">
                <a href="{{ url('/') }}" class="text-muted small text-decoration-none border-bottom border-secondary pb-1">
                    Atau ke Dashboard Utama
                </a>
            </div>
        </div>
    </div>

</body>
</html>