<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Komputer - VortexPlay</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS Laravel -->
    <link rel="stylesheet" href="{{ asset('css/komputer.css') }}">
</head>
<body>

    <div class="dashboard-container">

        <!-- Sidebar Menu -->
        <aside class="sidebar-menu">
            <div class="logo-container">
                <img src="{{ asset('asset/Desain_Tanpa_Judul__2_-removebg-preview.png') }}" alt="VortexPlay Logo" class="logo-img">
            </div>

            <nav class="menu-items">
                <a href="{{ route('dashboard') }}" class="nav-button">
                    <img src="{{ asset('asset/user.png') }}" alt="Pengguna" class="nav-icon">
                    <span>Pengguna</span>
                </a>
                <a href="{{ route('pemesanan.index') }}" class="nav-button">
                    <img src="{{ asset('asset/script.png') }}" alt="Pemesanan" class="nav-icon">
                    <span>Pemesanan</span>
                </a>
                <a href="{{ route('komputer') }}" class="nav-button active" aria-current="page">
                    <img src="{{ asset('asset/computer.png') }}" alt="Komputer" class="nav-icon">
                    <span>Komputer</span>
                </a>
            </nav>
        </aside>

        <!-- Area Kanan -->
        <div class="content-wrapper">

            <!-- Top Header -->
            <header class="top-header">
                <div class="user-profile">
                    <button type="button" class="btn-icon">
                        <img src="{{ asset('asset/notification.png') }}" alt="Notifikasi" class="header-icon">
                    </button>

                    <div class="profile-divider"></div>

                    <div class="profile-dropdown-wrapper">
                        <div class="profile-info" id="profileToggle">
                            <i class="fa-solid fa-circle-user profile-avatar"></i>
                            <div class="user-text">
                                <span class="user-name">admin</span>
                                <span class="user-role">Administrator</span>
                            </div>
                            <i class="fa-solid fa-chevron-down dropdown-icon" id="chevronIcon"></i>
                        </div>

                        <div class="profile-dropdown-menu" id="profileMenu">
                            <div class="dropdown-header">
                                <i class="fa-solid fa-circle-user dropdown-avatar"></i>
                                <span class="dropdown-name">admin</span>
                                <span class="dropdown-role">Administrator</span>
                            </div>
                            <div class="dropdown-body">
                                <button type="button" class="btn-logout" onclick="logoutUser()">Log out</button>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Panel Utama -->
            <main class="main-card">

                <div class="page-header-row">
                    <div class="page-title">
                        <h1>Komputer</h1>
                        <p>Pantau komputer yang tersedia dengan lebih efisien</p>
                    </div>

                    <!-- Tombol Logo (+) Tambah Komputer -->
                    <button type="button" class="btn-add-komputer" id="openTambahModal" title="Tambah Komputer">
                        <img src="{{ asset('asset/akar-icons_plus.png') }}" alt="Tambah Komputer">
                    </button>
                </div>

                <!-- Container untuk Kotak-kotak PC -->
                <div class="pc-grid-container">

                    @forelse ($komputers as $komputer)
                    <!-- PC {{ $komputer->nomor_komputer }} -->
                    <div class="pc-card" id="pc-card-{{ $komputer->id_komputer }}">
                        <div class="pc-icon-wrapper">
                            <i class="fa-solid fa-computer"></i>
                        </div>
                        <h3>KOMPUTER {{ str_pad($komputer->nomor_komputer, 2, '0', STR_PAD_LEFT) }}</h3>
                        <div class="status-text">Status <span class="status-value">{{ strtoupper($komputer->status_komputer) }}</span></div>

                        <!-- Tombol dan Dropdown Status + Deskripsi -->
                        <div class="status-action-wrapper">
                            <button type="button" class="btn-ubah" onclick="toggleStatusMenu(this)">UBAH</button>
                            <div class="status-dropdown">
                                <div class="status-dropdown-header">Pilih Status</div>
                                <form method="POST" action="{{ route('komputer.updateStatus', $komputer->id_komputer) }}" class="status-form">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="status_komputer" value="kosong" class="status-item">
                                        <span class="dot dot-kosong"></span> Kosong
                                    </button>
                                    <button type="submit" name="status_komputer" value="dipakai" class="status-item">
                                        <span class="dot dot-tersedia"></span> Tersedia
                                    </button>
                                    <button type="submit" name="status_komputer" value="maintenance" class="status-item">
                                        <span class="dot dot-terpakai"></span> Terpakai
                                    </button>
                                    <button type="submit" name="status_komputer" value="dipesan" class="status-item">
                                        <span class="dot dot-dipesan"></span> Dipesan
                                    </button>

                                    <textarea
                                        name="deskripsi"
                                        class="status-deskripsi-input"
                                        placeholder="Deskripsi ..."
                                        rows="3">{{ $komputer->deskripsi ?? '' }}</textarea>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p style="color: white; opacity: 0.6;">Belum ada data komputer.</p>
                    @endforelse

                </div>

            </main>
        </div>

    </div>

    <!-- Modal Pop-up Tambah Komputer -->
    <div class="modal-overlay" id="tambahKomputerModal">
        <div class="modal-box">
            <h2 class="modal-title">Tambah Komputer</h2>
            <form method="POST" action="{{ Route::has('komputer.store') ? route('komputer.store') : url('/komputer') }}" class="modal-form">
                @csrf
                <input
                    type="text"
                    name="nomor_komputer"
                    class="modal-input"
                    placeholder="Nama"
                    required>

                <textarea
                    name="deskripsi"
                    class="modal-textarea"
                    placeholder="Spesifikasi Komputer"
                    required></textarea>

                <button type="submit" class="btn-modal-submit">Tambah</button>
            </form>
        </div>
    </div>

    <!-- Script Dropdown Profile, Status & Modal -->
    <script>
        // --- Script Profil ---
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');
        const chevronIcon = document.getElementById('chevronIcon');

        profileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
            chevronIcon.classList.toggle('rotate');
        });

        function logoutUser() {
            alert("Berhasil Log out!");
        }

        // --- Script Dropdown Status PC ---
        function toggleStatusMenu(button) {
            const wrapper = button.parentElement;
            const dropdown = wrapper.querySelector('.status-dropdown');
            
            document.querySelectorAll('.status-dropdown').forEach(menu => {
                if (menu !== dropdown) menu.classList.remove('show');
            });

            dropdown.classList.toggle('show');
        }

        // --- Script Modal Tambah Komputer ---
        const openTambahBtn = document.getElementById('openTambahModal');
        const tambahModal = document.getElementById('tambahKomputerModal');

        if (openTambahBtn && tambahModal) {
            openTambahBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                tambahModal.classList.add('show');
            });

            tambahModal.addEventListener('click', (e) => {
                if (e.target === tambahModal) {
                    tambahModal.classList.remove('show');
                }
            });
        }

        // Tutup semua dropdown / modal jika klik di luar atau tekan Esc
        document.addEventListener('click', function (e) {
            if (!profileToggle.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.remove('show');
                chevronIcon.classList.remove('rotate');
            }
            
            if (!e.target.closest('.status-action-wrapper')) {
                document.querySelectorAll('.status-dropdown').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && tambahModal) {
                tambahModal.classList.remove('show');
            }
        });
    </script>

</body>
</html>