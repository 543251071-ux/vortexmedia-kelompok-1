<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - Vortex Play</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
            background:
                linear-gradient(180deg, rgba(3, 38, 50, 0.78), rgba(2, 27, 36, 0.88)),
                url('{{ asset('asset/background1.jpeg') }}') center / cover fixed;
        }
        .receipt-card {
            width: 100%;
            max-width: 420px;
            padding: 34px 38px;
            text-align: center;
            border: 1.5px solid rgba(255, 255, 255, 0.42);
            border-radius: 18px;
            background: rgba(13, 72, 90, 0.72);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
        }
        .brand {
            height: 30px;
            margin-bottom: 18px;
        }
        .success-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 14px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #ffffff;
            color: #1c7e79;
            font-size: 34px;
            font-weight: 700;
        }
        h1 { margin-bottom: 22px; font-size: 22px; }
        .receipt-details {
            padding: 18px;
            text-align: left;
            border: 1px solid rgba(255, 255, 255, 0.38);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 7px 0;
            font-size: 12.5px;
        }
        .detail-row span:first-child { color: rgba(255, 255, 255, 0.65); }
        .detail-row strong { text-align: right; }
        .total-row {
            margin-top: 8px;
            padding-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, 0.35);
            font-size: 15px;
        }
        .actions { display: grid; gap: 10px; margin-top: 20px; }
        .receipt-button {
            display: block;
            padding: 12px;
            border: 1px solid rgba(255, 255, 255, 0.55);
            border-radius: 8px;
            color: #ffffff;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.12);
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
        }
        @media print {
            body { background: #ffffff; color: #111827; padding: 0; }
            .receipt-card { max-width: none; border: 0; box-shadow: none; background: #ffffff; }
            .actions { display: none; }
            .receipt-details { color: #111827; border-color: #d1d5db; background: #ffffff; }
            .detail-row span:first-child { color: #4b5563; }
        }
    </style>
</head>
<body>
    <div class="receipt-card">
        <img src="{{ asset('asset/picture.png') }}" alt="Vortex Play" class="brand">
        <div class="success-icon">✓</div>
        <h1>{{ $pemesanan?->status === 'diterima' ? 'Pembayaran Berhasil!' : 'Pemesanan Berhasil!' }}</h1>

        @if ($pemesanan)
            <div class="receipt-details">
                <div class="detail-row">
                    <span>ID Pemesanan</span>
                    <strong>#{{ str_pad($pemesanan->id_pemesanan, 6, '0', STR_PAD_LEFT) }}</strong>
                </div>
                <div class="detail-row">
                    <span>Nama Pemesan</span>
                    <strong>{{ $pemesanan->user->nama ?? '-' }}</strong>
                </div>
                <div class="detail-row">
                    <span>Komputer</span>
                    <strong>Komputer {{ str_pad($pemesanan->komputer->nomor_komputer ?? 0, 2, '0', STR_PAD_LEFT) }}</strong>
                </div>
                <div class="detail-row">
                    <span>Tanggal</span>
                    <strong>{{ \Carbon\Carbon::parse($pemesanan->tanggal_pemesanan)->translatedFormat('d/m/Y') }}</strong>
                </div>
                <div class="detail-row">
                    <span>Durasi</span>
                    <strong>{{ $pemesanan->lama_pemesanan }} Jam</strong>
                </div>
                <div class="detail-row total-row">
                    <span>Total Pembayaran</span>
                    <strong>Rp {{ number_format($pemesanan->nominal, 0, ',', '.') }}</strong>
                </div>
            </div>
        @else
            <p>Data pemesanan tidak ditemukan.</p>
        @endif

        <div class="actions">
            @if ($pemesanan)
                
            @endif
            <a href="{{ route('home') }}" class="receipt-button">Back to Homepage</a>
        </div>
    </div>
</body>
</html>
