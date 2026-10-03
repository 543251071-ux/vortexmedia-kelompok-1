<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <title>Login Page</title>
</head>
<body>

    <div class="login-card">
        <img src="{{ asset('asset/logo.png') }}" alt="Gambar Logo">

        <h1>Welcome Back!</h1>
        <p>Please log in before using our website.</p>

        <form action="{{ route('login.perform') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div style="color: #ff4d4d; background: #ffe6e6; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                    {{ $errors->first() }}
                </div>
            @endif

            <label for="email">Email</label>
            <div class="input-box">
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukan Email..." required class="UsernameText">
                <i class="fa-regular fa-user input-icon"></i>
            </div>

            <label for="password">Password</label>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Masukan Password..." required class="PasswordText">
                <i class="fa-regular fa-eye input-icon" id="togglePassword" style="cursor: pointer;"></i>
            </div>

            <button class="btn-login"
            type="submit" style="margin-top: 20px; width: 100%; padding: 12px; cursor: pointer;">Login</button>
        </form>
    </div>

</body>
</html>