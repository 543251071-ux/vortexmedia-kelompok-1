<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/register.css">
    <title>Register Page</title>
</head>
<body>
    <div class="login-card">
        <img src="../asset/picture.png" alt="Gambar Logo">

        <h1>Create Account</h1>
        <p>Please Register before using our website</p>

        @if ($errors->any())
            <div style="color: #ff4d4d; background: #ffe6e6; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 14px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.perform') }}" method="POST">
            @csrf

            <label for="name">Name</label>
            <div class="input-box">
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama..." required maxlength="40" autocomplete="name" class="UsernameText">
            </div>

            <label for="email">Email</label>
            <div class="input-box">
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukan Email..." required maxlength="100" autocomplete="username" class="UsernameText">
                <i class="fa-regular fa-user input-icon"></i>
            </div>

            <label for="password">Password</label>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Masukkan Password..." required autocomplete="new-password" class="PasswordText">
                <i class="fa-regular fa-eye-slash input-icon" id="togglePassword" style="cursor: pointer;"></i>
            </div>

            <label for="password_confirmation">Confirm Password</label>
            <div class="input-box">
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password..." required autocomplete="new-password" class="PasswordText">
            </div>

            <button class="btn-login"
                type="submit" style="margin-top: 20px; width: 100%; padding: 12px; cursor: pointer;">Register</button>
        </form>

        <div class="signup-text" style="font-size: 15px; margin-top: 20px; color: white;">
            Sudah punya akun? <a href="{{ route('login') }}">Login</a>
        </div>

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