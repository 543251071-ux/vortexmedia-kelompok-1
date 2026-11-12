<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Slot - Vortex Play</title>

    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/rent.css') }}">
</head>
<body>

    <div class="rent-container">
        
        <div class="rent-card">
            
            <!-- Brand Logo at Top Left -->
            <a href="{{ route('home') }}" class="card-brand">
                <span class="card-brand-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 3.5C4 2.67 4.9 2.16 5.6 2.58L20.4 11.08C21.1 11.48 21.1 12.52 20.4 12.92L5.6 21.42C4.9 21.84 4 21.33 4 20.5V3.5Z" />
                        <circle cx="9" cy="12" r="3" fill="#011b24" />
                    </svg>
                </span>
                <span class="card-brand-text">VORTEX PLAY</span>
            </a>

            <!-- Header Titles -->
            <div class="rent-header">
                <h1 class="rent-title">Rent</h1>
                <p class="rent-subtitle">Please fill out the form below to secure your gaming slot</p>
            </div>

            @if(session('success'))
                <div class="alert-box alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-box alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('rent.submit') }}" method="POST" class="rent-form">
                @csrf

                <!-- Name Input -->
                <div class="form-group">
                    <label for="nama" class="form-label">Name</label>
                    <input 
                        type="text" 
                        id="nama" 
                        name="nama" 
                        class="form-input" 
                        placeholder="Enter your full name" 
                        value="{{ old('nama', auth()->user()->nama ?? '') }}" 
                        required>
                </div>

                <!-- Phone Number Input -->
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="nomor_telepon" 
                        class="form-input" 
                        placeholder="e.g., 081234567xxx" 
                        value="{{ old('nomor_telepon', auth()->user()->nomor_telepon ?? '') }}" 
                        required>
                </div>

                <!-- Email Address Input -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="enter your email" 
                        value="{{ old('email', auth()->user()->email ?? '') }}" 
                        required>
                </div>

                <!-- Remember Me Checkbox -->
                <div class="remember-row">
                    <label class="custom-checkbox-label">
                        <input type="checkbox" name="remember" value="1" checked>
                        <span>Remember Me</span>
                    </label>
                </div>

                <!-- Continue to Payment Button -->
                <button type="submit" class="btn-submit-payment">
                    Continue to Payment
                </button>

                <!-- Back to Homepage Link -->
                <div class="back-link">
                    <a href="{{ route('home') }}">Back to Homepage</a>
                </div>

            </form>

        </div>

    </div>

</body>
</html>
