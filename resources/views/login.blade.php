<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Login Page</title>
</head>
<body>
    <div class="login-card">
        <img src="../asset/logo.png" alt="Gambar Logo">

        <h1>Welcome back!</h1>
        <p>Please log in before using our website.</p>

        @if ($errors->any())
            <div style="color: #ff4d4d; background: #ffe6e6; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.perform') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <div class="input-box">
                <input type="text" id="email" name="email" value="{{ old('email') }}" placeholder="Masukan Email..." required maxlength="21" autocomplete="username" class="UsernameText">
                <i class="fa-regular fa-user input-icon"></i>
            </div>

            <label for="password">Password</label>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Masukkan Password..." required maxlength="19" autocomplete="current-password" class="PasswordText">
                <i class="fa-regular fa-eye-slash input-icon" id="togglePassword" style="cursor: pointer;"></i>
            </div>

            <button class="btn-login"
                type="submit" style="margin-top: 20px; width: 100%; padding: 12px; cursor: pointer;">Login</button>
        </form>

        <script>
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');

            togglePassword.addEventListener('click', function () {
                if (passwordInput.type === "text") {
                    passwordInput.type = "password";
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = "text";
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        </script>
    </div>
</body>
</html>