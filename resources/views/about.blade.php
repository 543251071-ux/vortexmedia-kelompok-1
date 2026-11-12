<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vortex Play - About Us</title>

    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
</head>
<body>

    <div class="page-container">

        <!-- Top Navigation Bar -->
        <header class="top-navbar">
            <a href="{{ route('home') }}" class="brand-logo">
                <span class="brand-icon">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 3.5C4 2.67 4.9 2.16 5.6 2.58L20.4 11.08C21.1 11.48 21.1 12.52 20.4 12.92L5.6 21.42C4.9 21.84 4 21.33 4 20.5V3.5Z" />
                        <circle cx="9" cy="12" r="3" fill="#011b24" />
                    </svg>
                </span>
                <span class="brand-text">VORTEX PLAY</span>
            </a>

            <nav>
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                    <li><a href="{{ route('rent') }}" class="nav-link">Rent</a></li>
                    <li><a href="{{ route('about') }}" class="nav-link active">About</a></li>
                </ul>
            </nav>

            <div class="nav-controls">
                <button type="button" class="btn-notification" title="Notifikasi">
                    <i class="fa-regular fa-bell"></i>
                </button>

                <div class="nav-divider"></div>

                <div class="profile-dropdown-wrapper">
                    <div class="profile-info" id="profileToggle">
                        <i class="fa-solid fa-circle-user profile-avatar"></i>
                        <div class="user-text">
                            <span class="user-name">{{ auth()->user()->nama ?? 'User' }}</span>
                            <span class="user-role">{{ ucfirst(auth()->user()->role ?? 'User') }}</span>
                        </div>
                        <i class="fa-solid fa-chevron-down dropdown-icon" id="chevronIcon"></i>
                    </div>

                    <div class="profile-dropdown-menu" id="profileMenu">
                        <div class="dropdown-user-header">
                            <i class="fa-solid fa-circle-user dropdown-avatar"></i>
                            <div class="dropdown-details">
                                <span class="dropdown-name">{{ auth()->user()->nama ?? 'User' }}</span>
                                <span class="dropdown-role">{{ auth()->user()->email ?? 'user@vortexplay.id' }}</span>
                            </div>
                        </div>

                        <div class="dropdown-menu-links">
                            @if(auth()->check() && auth()->user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="dropdown-link-item">
                                    <i class="fa-solid fa-gauge"></i>
                                    <span>Dashboard Admin</span>
                                </a>
                            @endif
                            <a href="{{ route('rent') }}" class="dropdown-link-item">
                                <i class="fa-solid fa-gamepad"></i>
                                <span>Pesan Komputer</span>
                            </a>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" class="btn-logout-action">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Log out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">

            <section class="about-hero-card">
                <h1 class="about-header-title">Tentang Vortex Play</h1>
                <p class="about-intro-text">
                    Selamat datang di <strong>Vortex Play</strong>, pusat warnet dan esports gaming lounge modern yang dirancang untuk memberikan pengalaman bermain game terbaik dengan performa maksimal, kenyamanan premium, dan komunitas gamers yang solid.
                </p>

                <!-- Features Grid -->
                <div class="features-grid">
                    <div class="feature-box">
                        <i class="fa-solid fa-microchip feature-icon"></i>
                        <h3 class="feature-heading">Spek Komputer Gahar</h3>
                        <p class="feature-desc">Didukung prosesor generasi terbaru, kartu grafis NVIDIA RTX, dan monitor 240Hz untuk respon gameplay tanpa lag.</p>
                    </div>

                    <div class="feature-box">
                        <i class="fa-solid fa-bolt feature-icon"></i>
                        <h3 class="feature-heading">Koneksi Fiber Optic</h3>
                        <p class="feature-desc">Dedicated bandwidth berkecepatan tinggi dengan ping ultra rendah untuk game kompetitif seperti Valorant, Dota 2, dan CS2.</p>
                    </div>

                    <div class="feature-box">
                        <i class="fa-solid fa-couch feature-icon"></i>
                        <h3 class="feature-heading">Ergonomis & Nyaman</h3>
                        <p class="feature-desc">Kursi gaming ergonomis, ruangan ber-AC dingin, bebas asap rokok, serta suasana cyber lounge yang imersif.</p>
                    </div>

                    <div class="feature-box">
                        <i class="fa-solid fa-headset feature-icon"></i>
                        <h3 class="feature-heading">Layanan 24/7 & Canteen</h3>
                        <p class="feature-desc">Staf siap membantu kebutuhan Anda 24 jam dengan berbagai pilihan makanan, camilan, dan minuman dingin.</p>
                    </div>
                </div>

                <!-- Call to action banner -->
                <div class="cta-banner">
                    <div class="cta-text">
                        <h3>Siap Bermain?</h3>
                        <p>Booking meja PC favorit Anda sekarang dan amankan slot gaming Anda hari ini!</p>
                    </div>
                    <a href="{{ route('rent') }}" class="btn-cta">
                        <i class="fa-solid fa-gamepad" style="margin-right: 8px;"></i> Sewa PC Sekarang
                    </a>
                </div>
            </section>

        </main>

    </div>

    <!-- Dropdown Script -->
    <script>
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');
        const chevronIcon = document.getElementById('chevronIcon');

        if (profileToggle && profileMenu) {
            profileToggle.addEventListener('click', (e) => {
                e.stopPropagation();
                profileMenu.classList.toggle('show');
                if (chevronIcon) {
                    chevronIcon.classList.toggle('rotate');
                }
            });

            document.addEventListener('click', (e) => {
                if (!profileToggle.contains(e.target) && !profileMenu.contains(e.target)) {
                    profileMenu.classList.remove('show');
                    if (chevronIcon) {
                        chevronIcon.classList.remove('rotate');
                    }
                }
            });
        }
    </script>

</body>
</html>
