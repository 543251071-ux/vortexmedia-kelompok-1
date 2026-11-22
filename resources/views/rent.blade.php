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

    <!-- QRCode.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>

    @php
        $isPaymentStep = session('success') && !$errors->any();
        $paymentToken = session('payment_token', \Illuminate\Support\Str::random(32));
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
                        {{-- QR dinamis di-generate oleh QRCode.js --}}
                        <div id="qrcode"></div>
                    </div>
                </div>

                {{-- Status menunggu konfirmasi --}}
                <p id="waitingText" style="color: rgba(255,255,255,0.4); font-size:0.8rem; margin-bottom: 12px; text-align:center;">
                    Menunggu konfirmasi pembayaran...
                </p>

                {{-- [DEMO] Tombol simulasi bayar -- hapus saat production --}}
                <button type="button" id="demoBtn" class="btn-glass-primary" onclick="simulasiDemo()">
                    Konfirmasi Bayar
                </button>

                <button type="button" class="btn-glass-primary" onclick="showCancelConfirm()">
                    Cancel Payment
                </button>

                <div class="back-link">
                    <a href="{{ route('home') }}">Back to Homepage</a>
                </div>

                {{-- Token untuk polling --}}
                <input type="hidden" id="paymentToken" value="{{ $paymentToken }}">
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

        // ==========================================
        // GENERATE QR CODE DINAMIS
        // ==========================================
        const paymentToken = document.getElementById('paymentToken').value;
        const confirmUrl = `{{ url('/payment/confirm') }}/${paymentToken}`;

        new QRCode(document.getElementById('qrcode'), {
            text: confirmUrl,
            width: 255,
            height: 255,
            colorDark: '#000000',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.M,
        });

        // ==========================================
        // LISTEN PAYMENT — SSE (real-time) + fallback polling
        // ==========================================
        let pollingInterval = null;
        let eventSource = null;

        function startListening() {
            const token = document.getElementById('paymentToken').value;

            // Coba SSE dulu (lebih real-time, tidak perlu interval)
            if (typeof EventSource !== 'undefined') {
                eventSource = new EventSource(`/payment/stream/${token}`);

                eventSource.onmessage = function (e) {
                    const data = JSON.parse(e.data);

                    if (data.status === 'paid') {
                        eventSource.close();
                        redirectToStruk(token);
                    }

                    if (data.status === 'timeout') {
                        eventSource.close();
                        // Fallback ke polling jika SSE timeout
                        startPollingFallback(token);
                    }
                };

                eventSource.onerror = function () {
                    eventSource.close();
                    // Fallback ke polling jika SSE error
                    startPollingFallback(token);
                };
            } else {
                // Browser tidak support SSE, langsung pakai polling
                startPollingFallback(token);
            }
        }

        function startPollingFallback(token) {
            pollingInterval = setInterval(async () => {
                try {
                    const res = await fetch(`/payment/status/${token}`);
                    const data = await res.json();

                    if (data.status === 'paid') {
                        clearInterval(pollingInterval);
                        redirectToStruk(token);
                    }
                } catch (e) {
                    // Abaikan error jaringan, coba lagi
                }
            }, 3000);
        }

        function redirectToStruk(token) {
            window.location.href = `/struk/${token}`;
        }

        // Mulai listening jika halaman payment langsung tampil
        if (stepPayment && !stepPayment.classList.contains('hidden')) {
            startListening();
        }

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
            if (pollingInterval) { clearInterval(pollingInterval); }
            if (eventSource) { eventSource.close(); }
            stepCancel.classList.add('hidden');
            stepRent.classList.remove('hidden');
        }

        // ==========================================
        // [DEMO] Simulasi konfirmasi pembayaran dari browser
        // Hapus fungsi ini saat production
        // ==========================================
        async function simulasiDemo() {
            const token = document.getElementById('paymentToken').value;
            const btn   = document.getElementById('demoBtn');

            btn.disabled    = true;
            btn.textContent = '⏳ Memproses...';

            try {
                await fetch(`/payment/confirm/${token}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type'  : 'application/json',
                        'X-CSRF-TOKEN'  : '{{ csrf_token() }}',
                    },
                });
                // SSE/polling akan mendeteksi perubahan & redirect otomatis
                // tapi redirect langsung juga sebagai fallback cepat
                redirectToStruk(token);
            } catch (e) {
                btn.disabled    = false;
                btn.textContent = '⚡ Demo: Konfirmasi Bayar';
                alert('Gagal, coba lagi.');
            }
        }
    </script>

    <style>
        /* [DEMO] Tombol simulasi — hapus saat production */
        .btn-demo {
            width: 100%;
            padding: 11px;
            margin-bottom: 10px;
            background: transparent;
            border: 1px dashed rgba(255, 220, 50, 0.5);
            border-radius: 10px;
            color: rgba(255, 220, 50, 0.8);
            font-family: 'Poppins', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            letter-spacing: 0.3px;
            transition: all 0.2s;
        }
        .btn-demo:hover {
            background: rgba(255, 220, 50, 0.08);
            border-color: rgba(255, 220, 50, 0.8);
            color: rgba(255, 220, 50, 1);
        }
        .btn-demo:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }
    </style>

</body>
</html>