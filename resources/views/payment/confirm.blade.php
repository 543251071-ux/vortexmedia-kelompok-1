<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pembayaran - Vortex Play</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #0a1628 0%, #0d2137 50%, #0a1628 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .confirm-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(0, 198, 255, 0.2);
            border-radius: 20px;
            padding: 40px 30px;
            max-width: 380px;
            width: 100%;
            text-align: center;
        }

        .brand-logo {
            margin-bottom: 24px;
        }

        .brand-logo img {
            height: 36px;
        }

        .icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(0, 198, 255, 0.1);
            border: 2px solid rgba(0, 198, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .icon-wrapper svg {
            width: 40px;
            height: 40px;
            color: #00c6ff;
            fill: none;
            stroke: #00c6ff;
            stroke-width: 2;
        }

        h1 {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        p.subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .amount-box {
            background: rgba(0, 198, 255, 0.08);
            border: 1px solid rgba(0, 198, 255, 0.2);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 32px;
        }

        .amount-label {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .amount-value {
            color: #00c6ff;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .btn-confirm {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            border: none;
            border-radius: 10px;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
        }

        .btn-confirm:hover {
            opacity: 0.9;
        }

        .btn-confirm:active {
            transform: scale(0.98);
        }

        .btn-confirm:disabled {
            background: rgba(255, 255, 255, 0.1);
            cursor: not-allowed;
            color: rgba(255, 255, 255, 0.4);
        }

        /* Success State */
        .success-state {
            display: none;
        }

        .success-state.visible {
            display: block;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(0, 255, 136, 0.1);
            border: 2px solid rgba(0, 255, 136, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .success-icon svg {
            width: 40px;
            height: 40px;
            stroke: #00ff88;
            fill: none;
            stroke-width: 2.5;
        }

        .success-text {
            color: #00ff88;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .success-sub {
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 0 auto;
        }

        .loading-spinner.visible {
            display: inline-block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>

    <div class="confirm-card">

        <div class="brand-logo">
            <img src="{{ asset('asset/picture.png') }}" alt="Vortex Play">
        </div>

        {{-- Tampilan awal: tombol konfirmasi --}}
        <div id="defaultState">
            <div class="icon-wrapper">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
            </div>

            <h1>Konfirmasi Pembayaran</h1>
            <p class="subtitle">Tekan tombol di bawah untuk mengkonfirmasi bahwa kamu telah melakukan pembayaran QRIS.</p>

            <div class="amount-box">
                <div class="amount-label">Total Pembayaran</div>
                <div class="amount-value">
                    Rp {{ number_format($pemesanan->nominal ?? 0, 0, ',', '.') }}
                </div>
            </div>

            <button class="btn-confirm" id="confirmBtn" onclick="doConfirm()">
                <span id="btnText">✓ &nbsp; Saya Sudah Bayar</span>
                <div class="loading-spinner" id="spinner"></div>
            </button>
        </div>

        {{-- Tampilan setelah berhasil --}}
        <div class="success-state" id="successState">
            <div class="success-icon">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
            <div class="success-text">Pembayaran Dikonfirmasi!</div>
            <p class="success-sub">Pembayaran telah berhasil.</p>
            <div style="margin-top: 20px;">
                <a id="receiptLink" href="{{ route('payment.struk', ['token' => $token]) }}" class="btn-confirm" style="display: inline-block; text-decoration: none; text-align: center;">
                    Lihat Struk Pembayaran
                </a>
            </div>
        </div>

    </div>

    <script>
        const token = "{{ $token }}";

        function doConfirm() {
            const btn = document.getElementById('confirmBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('spinner');

            btn.disabled = true;
            btnText.style.display = 'none';
            spinner.classList.add('visible');

            fetch(`/payment/confirm/${token}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'paid') {
                    window.location.href = document.getElementById('receiptLink').href;
                }
            })
            .catch(() => {
                btn.disabled = false;
                btnText.style.display = 'inline';
                spinner.classList.remove('visible');
                alert('Gagal menghubungi server, coba lagi.');
            });
        }
    </script>

</body>
</html>
