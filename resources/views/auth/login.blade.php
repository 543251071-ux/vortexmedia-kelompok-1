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

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <label for="email">Email</label>
            <div class="input-box">
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Masukan Email..." required autofocus autocomplete="username" class="UsernameText">
                <i class="fa-regular fa-user input-icon"></i>
            </div>
            <x-input-error :messages="$errors->get('email')" style="color: #ff6b6b; font-size: 12px; margin-top: 4px; align-self: flex-start;" />
            
            <!-- Password -->
            <label for="password">Password</label>
            <div class="input-box">
                <input type="password" id="password" name="password" placeholder="Masukan Password..." required autocomplete="current-password" class="PasswordText"> 
                <i class="fa-regular fa-eye input-icon" id="togglePassword" style="cursor: pointer;"></i>
            </div>
            <x-input-error :messages="$errors->get('password')" style="color: #ff6b6b; font-size: 12px; margin-top: 4px; align-self: flex-start;" />

            <!-- Remember Me & Forgot Password -->
            <div class="wrapper">
                <div class="remember-box">
                    <input type="checkbox" id="remember_me" name="remember" class="remember">
                    <label for="remember_me" class="taglineRA" style="margin: 0;">Remember Me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="taglineFP">Forgot Password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login">Sign In</button>

            <!-- Register Link -->
            @if (Route::has('register'))
                <p class="signup-text">
                    Don't have account? <a href="{{ route('register') }}">Sign Up</a>
                </p>
            @endif
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        }
    </script>
</body>
</html>
