<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard VortexPlay</title>
    
    <!-- Font Google (Poppins) & Font Awesome CDN -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Link CSS Utama Laravel -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <div class="dashboard-container">
        
        <!-- Sidebar Menu -->
        <aside class="siderbar-menu">
            <div class="logo-container">
                <img src="{{ asset('../asset/logo.png') }}" alt="Logo" class="Image"> 
            </div>

            <div class="menu-items">
                <button type="button" class="nav-button active">
                    <img src="{{ asset('../asset/user.png') }}" alt="Pengguna" class="nav-icon">
                    <span>Pengguna</span>
                </button>
                <button type="button" class="nav-button">
                    <img src="{{ asset('../asset/script.png') }}" alt="Pemesanan" class="nav-icon">
                    <span>Pemesanan</span>
                </button>
                <button type="button" class="nav-button">
                    <img src="{{ asset('../asset/computer.png') }}" alt="Komputer" class="nav-icon">
                    <span>Komputer</span>
                </button>
            </div>
        </aside>

        <!-- Wrapper Konten Sebelah Kanan -->
        <div class="content-wrapper">
            
            <!-- Header Profil Admin -->
            <header class="top-header">
                <div class="user-profile">
                    <!-- Tombol Lonceng Notifikasi -->
                    <button type="button" class="btn-icon">
                        <img src="{{ asset('../asset/notification.png') }}" alt="Notifikasi" class="header-icon">
                    </button>

                    <!-- Garis Pemisah Vertikal -->
                    <div class="profile-divider"></div>

                    <!-- Detail Profil User Dinamis dari Database -->
                    <div class="profile-info">
                        <i class="fa-solid fa-circle-user profile-avatar"></i>
                        <div class="user-text">
                            <span class="user-name">{{ Auth::user()->nama ?? Auth::user()->email }}</span>
                            <span class="user-role">Administrator</span>
                        </div>
                        
                        <!-- Form Logout -->
                        <form action="{{ route('logout') }}" method="POST" style="margin-left: 10px;">
                            @csrf
                            <button type="submit" class="btn-action" style="padding: 4px 10px; font-size: 11px;">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="main-content">
                
                <!-- Judul Halaman -->
                <div class="page-title">
                    <h1>Halo, {{ Auth::user()->nama ?? 'Admin' }} VortexPlay</h1>
                    <p>Pantau reservasi aktif dan status billing PC hari ini.</p>
                </div>

                <!-- Cards Stats -->
                <section class="stats-grid">
                    <!-- Card 1: Pendapatan -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <img src="{{ asset('../asset/akar-icons_statistic-up.png') }}" alt="Statistik" class="stat-icon">
                        </div>
                        <h3>Rp. {{ number_format($pendapatanHariIni, 0, ',', '.') }}</h3>
                        <span class="stat-subtext">pendapatan hari ini</span>
                    </div>

                    <!-- Card 2: Pesanan Hari Ini -->
                    <div class="stat-card">
                        <div class="stat-header">
                            <span>Pesanan Hari Ini</span>
                            <img src="{{ asset('../asset/basil_invoice-outline.png') }}" alt="Pesanan" class="stat-icon">
                        </div>
                        <h3>{{ $totalTransaksiHariIni }} Transaksi</h3>
                        <span class="stat-subtext">Transaksi yang sudah tercatat</span>
                    </div>
                </section>

                <!-- Card Tabel -->
                <section class="table-card">
                    <div class="card-header">
                        <h2>Pesanan Terbaru</h2>
                        <a href="#" class="see-all-link">
                            Lihat semua 
                            <img src="{{ asset('../asset/bitcoin-icons_arrow-right-filled.png') }}" alt="Panah" class="link-icon">
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama pelanggan</th>
                                    <th>Komputer</th>
                                    <th>Durasi</th>
                                    <th>Status</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pesananTerbaru as $index => $pesanan)
                                <tr>
                                    <td>{{ $index + 1 }}.</td>
                                    <td>{{ $pesanan->user->nama ?? '-' }}</td>
                                    <td>COMPUTER {{ str_pad($pesanan->komputer->nomor_komputer ?? '0', 2, '0', STR_PAD_LEFT) }}</td>
                                    <td>{{ $pesanan->lama_pemesanan }} Jam</td>
                                    <td>
                                        <span class="status-badge status-{{ $pesanan->status }}">
                                            {{ ucfirst($pesanan->status) }}
                                        </span>
                                    </td>
                                    <td class="text-center"><button type="button" class="btn-action">Aksi</button></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" style="text-align: center; padding: 20px; color: #999;">
                                        Belum ada pesanan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

            </main>
        </div>

    </div>

</body>
</html>