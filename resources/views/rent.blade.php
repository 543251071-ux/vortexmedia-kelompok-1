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

                    <div class="form-group">
                        <label for="computer_id" class="form-label">Computer</label>
                        <select id="computer_id" name="computer_id" class="form-input" required>
                            <option value="">Pilih komputer</option>
                            @foreach ($komputers as $komputer)
                                <option value="{{ $komputer->id_komputer }}" @selected(old('computer_id') == $komputer->id_komputer)>
                                    Komputer {{ str_pad($komputer->nomor_komputer, 2, '0', STR_PAD_LEFT) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_pemesanan" class="form-label">Tanggal Pemesanan</label>
                        <input
                            type="date"
                            id="tanggal_pemesanan"
                            name="tanggal_pemesanan"
                            class="form-input"
                            min="{{ now()->toDateString() }}"
                            value="{{ old('tanggal_pemesanan', now()->toDateString()) }}"
                            required>
                    </div>

        

                    <div class="form-group">
                        <label for="lama_pemesanan" class="form-label">Durasi Pemesanan</label>
                        <select id="lama_pemesanan" name="lama_pemesanan" class="form-input" required>
                            @for ($jam = 1; $jam <= 24; $jam++)
                                <option value="{{ $jam }}" @selected((int) old('lama_pemesanan', 1) === $jam)>
                                    {{ $jam }} Jam
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="payment-total">
                        <span>total Payment :</span>
                        <strong id="totalPembayaran">7.000</strong>
                    </div>

                    <!-- Remember Me Checkbox -->
                

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

                @if ($pemesanan)
                    <div class="payment-total payment-total-payment">
                        <span>total Payment :</span>
                        <strong>{{ number_format($pemesanan->nominal, 0, ',', '.') }}</strong>
                    </div>
                @endif

                {{-- Tombol ini hanya membuka halaman struk --}}
                <p id="waitingText" style="color: rgba(255,255,255,0.4); font-size:0.8rem; margin-bottom: 12px; text-align:center;">
                    Klik tombol untuk membuka halaman struk.
                </p>

                {{-- Tombol menuju halaman struk --}}
                <a href="{{ route('struk') }}" class="btn-glass-primary" style="display: block; text-align: center; text-decoration: none;">
                    Konfirmasi Bayar
                </a>

                <button type="button" class="btn-glass-primary" onclick="showCancelConfirm()">
                    Cancel Payment
                </button>

                <div class="back-link">
                    <a href="{{ route('home') }}">Back to Homepage</a>
                </div>

                {{-- Token untuk QR code --}}
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
        const durationInput = document.getElementById('lama_pemesanan');
        const totalPayment = document.getElementById('totalPembayaran');

        function updateTotalPayment() {
            const duration = Number(durationInput.value || 1);
            totalPayment.textContent = new Intl.NumberFormat('id-ID').format(duration * 7000);
        }

        durationInput.addEventListener('change', updateTotalPayment);
        updateTotalPayment();

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