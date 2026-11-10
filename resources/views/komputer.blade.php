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

                <div class="page-title">
                    <h1>Komputer</h1>
                    <p>Pantau komputer yang tersedia dengan lebih efisien</p>
                </div>

                <!-- Container untuk Kotak-kotak PC -->
                <div class="pc-grid-container">
                    
                    <!-- PC 1 -->
                    <div class="pc-card">
                        <div class="pc-icon-wrapper">
                            <i class="fa-solid fa-desktop"></i>
                        </div>
                        <h3>KOMPUTER 01</h3>
                        <div class="status-text">Status <span class="status-value">KOSONG</span></div>
                        
                        <!-- Tombol dan Dropdown Status -->
                        <div class="status-action-wrapper">
                            <button type="button" class="btn-ubah" onclick="toggleStatusMenu(this)">UBAH</button>
                            <div class="status-dropdown">
                                <div class="status-dropdown-header">Pilih Status</div>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-kosong"></span> Kosong</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-tersedia"></span> Tersedia</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-terpakai"></span> Terpakai</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-dipesan"></span> Dipesan</button>
                            </div>
                        </div>
                    </div>

                    <!-- PC 2 -->
                    <div class="pc-card">
                        <div class="pc-icon-wrapper">
                            <i class="fa-solid fa-desktop"></i>
                        </div>
                        <h3>KOMPUTER 02</h3>
                        <div class="status-text">Status <span class="status-value">KOSONG</span></div>
                        
                        <div class="status-action-wrapper">
                            <button type="button" class="btn-ubah" onclick="toggleStatusMenu(this)">UBAH</button>
                            <div class="status-dropdown">
                                <div class="status-dropdown-header">Pilih Status</div>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-kosong"></span> Kosong</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-tersedia"></span> Tersedia</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-terpakai"></span> Terpakai</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-dipesan"></span> Dipesan</button>
                            </div>
                        </div>
                    </div>

                    <!-- PC 3 -->
                    <div class="pc-card">
                        <div class="pc-icon-wrapper">
                            <i class="fa-solid fa-desktop"></i>
                        </div>
                        <h3>KOMPUTER 03</h3>
                        <div class="status-text">Status <span class="status-value">KOSONG</span></div>
                        
                        <div class="status-action-wrapper">
                            <button type="button" class="btn-ubah" onclick="toggleStatusMenu(this)">UBAH</button>
                            <div class="status-dropdown">
                                <div class="status-dropdown-header">Pilih Status</div>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-kosong"></span> Kosong</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-tersedia"></span> Tersedia</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-terpakai"></span> Terpakai</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-dipesan"></span> Dipesan</button>
                            </div>
                        </div>
                    </div>

                    <!-- PC 4 -->
                    <div class="pc-card">
                        <div class="pc-icon-wrapper">
                            <i class="fa-solid fa-desktop"></i>
                        </div>
                        <h3>KOMPUTER 04</h3>
                        <div class="status-text">Status <span class="status-value">KOSONG</span></div>
                        
                        <div class="status-action-wrapper">
                            <button type="button" class="btn-ubah" onclick="toggleStatusMenu(this)">UBAH</button>
                            <div class="status-dropdown">
                                <div class="status-dropdown-header">Pilih Status</div>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-kosong"></span> Kosong</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-tersedia"></span> Tersedia</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-terpakai"></span> Terpakai</button>
                                <button type="button" class="status-item" onclick="pilihStatus(this)"><span class="dot dot-dipesan"></span> Dipesan</button>
                            </div>
                        </div>
                    </div>

                </div>

            </main>
        </div>

    </div>

    <!-- Script Dropdown Profile & Status -->
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
            
            // Tutup semua dropdown lain
            document.querySelectorAll('.status-dropdown').forEach(menu => {
                if (menu !== dropdown) menu.classList.remove('show');
            });

            dropdown.classList.toggle('show');
        }

        // Fungsi saat status dipilih
        function pilihStatus(button) {
            const statusText = button.textContent.trim();
            const wrapper = button.closest('.status-action-wrapper');
            const card = wrapper.closest('.pc-card');
            const statusValue = card.querySelector('.status-value');
            
            statusValue.textContent = statusText.toUpperCase();
            wrapper.querySelector('.status-dropdown').classList.remove('show');
        }

        // Tutup semua dropdown jika klik di luar
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
    </script>

</body>
</html>