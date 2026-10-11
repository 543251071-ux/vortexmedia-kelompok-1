<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VortexPlay - Halaman Utama</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body {
            background: linear-gradient(#002029d9, #002029d9), url('{{ asset("asset/background1.jpeg") }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
        }
        .card {
            background: rgba(0, 96, 122, 0.35);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 210, 255, 0.45);
            border-radius: 20px;
            padding: 48px;
            text-align: center;
            max-width: 480px;
            width: 90%;
        }
        h1 { font-size: 28px; font-weight: 700; margin-bottom: 12px; }
        p { color: rgba(255,255,255,0.75); font-size: 14px; margin-bottom: 32px; }
        .badge {
            display: inline-block;
            background: rgba(0,212,255,0.2);
            border: 1px solid rgba(0,212,255,0.5);
            color: #00d4ff;
            padding: 6px 20px;
            border-radius: 20px;
            font-size: 13px;
            margin-bottom: 32px;
        }
        .btn-logout {
            background: transparent;
            border: 1px solid rgba(255,255,255,0.35);
            color: #fff;
            padding: 10px 28px;
            border-radius: 8px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-logout:hover { background: rgba(220,53,69,0.2); border-color: #dc3545; color: #dc3545; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Selamat Datang! 👋</h1>
        <p>Halo, <strong>{{ Auth::user()->nama }}</strong>! Halaman utama user sedang dalam pengembangan.</p>
        <div class="badge">🚧 Coming Soon</div>
        <br>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn-logout">Logout</button>
        </form>
    </div>
</body>
</html>
