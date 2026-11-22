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

    @php
        $isPaymentStep = session('success') && !$errors->any();
    @endphp

    <div class="rent-container">
        
        <div class="rent-card">
            
            <!-- Brand Logo at Top Left -->
            <a href="{{ route('home') }}" class="card-brand">
                <img src="{{ asset('asset/picture.png') }}" alt="Vortex Play" class="card-brand-img">
            </a>

            <!-- ==========================================
                 TAHAP 1: FORM RENT
                 ========================================== -->
            <div id="stepRent" class="step-section {{ $isPaymentStep ? 'hidden' : '' }}">
                <div class="rent-header">
                    <h1 class="rent-title">Rent</h1>
                    <p class="rent-subtitle">Please fill out the form below to secure your gaming slot</p>
                </div>

                @if($errors->any())
                    <div class="alert-box alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

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
                            <input type="checkbox" name="remember" value="1">
                            <span>Remember Me</span>
                        </label>
                    </div>

                    <!-- Continue to Payment Button -->
                    <button type="submit" class="btn-glass-primary">
                        Continue to Payment
                    </button>

                    <!-- Back to Homepage Link -->
                    <div class="back-link">
                        <a href="{{ route('home') }}">Back to Homepage</a>
                    </div>
                </form>
            </div>

            <!-- ==========================================
                 TAHAP 2: PAYMENT (QRIS)
                 ========================================== -->
            <div id="stepPayment" class="step-section {{ $isPaymentStep ? '' : 'hidden' }}">
                <div class="rent-header">
                    <h1 class="rent-title">Payment</h1>
                    <p class="rent-subtitle">Kami hanya memakai qris</p>
                </div>

                <div class="qris-wrapper">
                    <div class="qris-box">
                        <img src="{{ asset('asset/qris.png') }}" alt="QRIS Vortex Play" class="qris-image">
                    </div>
                </div>

                <button type="button" class="btn-glass-primary" onclick="showCancelConfirm()">
                    Cancel Payment
                </button>

                <div class="back-link">
                    <a href="{{ route('home') }}">Back to Homepage</a>
                </div>
            </div>

            <!-- ==========================================
                 TAHAP 3: KONFIRMASI BATALKAN PEMBAYARAN
                 ========================================== -->
            <div id="stepCancel" class="step-section step-cancel-center hidden">
                <div class="rent-header">
                    <h1 class="rent-title">Batalkan</h1>
                    <p class="rent-subtitle cancel-subtitle">
                        Apakah anda yakin untuk membatalkan Pembayaran?
                    </p>
                </div>

                <div class="cancel-actions">
                    <button type="button" class="btn-glass-primary" onclick="confirmCancelPayment()">
                        Konfirmasi
                    </button>
                    <button type="button" class="btn-glass-primary" onclick="backToPayment()">
                        Batal
                    </button>
                </div>
            </div>

        </div>

    </div>

    <script>
        const stepRent = document.getElementById('stepRent');
        const stepPayment = document.getElementById('stepPayment');
        const stepCancel = document.getElementById('stepCancel');

        // Dari halaman Payment -> masuk ke konfirmasi Batalkan
        function showCancelConfirm() {
            stepPayment.classList.add('hidden');
            stepCancel.classList.remove('hidden');
        }

        // Klik "Batal" pada konfirmasi -> kembali ke halaman Payment (QRIS)
        function backToPayment() {
            stepCancel.classList.add('hidden');
            stepPayment.classList.remove('hidden');
        }

        // Klik "Konfirmasi" pada konfirmasi -> batalkan pembayaran & kembali ke form Rent
        function confirmCancelPayment() {
            stepCancel.classList.add('hidden');
            stepRent.classList.remove('hidden');
        }
    </script>

</body>
</html>