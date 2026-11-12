<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vortex Play - Home</title>

    <!-- Google Fonts Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
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
                    <li><a href="{{ route('home') }}" class="nav-link active">Home</a></li>
                    <li><a href="{{ route('rent') }}" class="nav-link">Rent</a></li>
                    <li><a href="{{ route('about') }}" class="nav-link">About</a></li>
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

            <!-- Card 1: Play and Repeat -->
            <section class="glass-card card-hero">
                <div class="card-body-text">
                    <h1 class="card-title">PLAY AND REPEAT</h1>
                    <p class="card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <a href="{{ route('rent') }}" class="btn-action">Rent</a>
                </div>

                <div class="card-image-wrapper">
                    <img src="{{ asset('asset/gaming-desk.png') }}" alt="Gaming Setup VortexPlay" class="card-image">
                </div>
            </section>

            <!-- Card 2: About us -->
            <section class="glass-card card-about">
                <div class="card-image-wrapper">
                    <img src="{{ asset('asset/cybercafe.png') }}" alt="VortexPlay Gaming Lounge" class="card-image">
                </div>

                <div class="card-body-text">
                    <h2 class="card-title card-title-about">About us</h2>
                    <p class="card-desc">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    </p>
                    <a href="{{ route('about') }}" class="btn-action">About</a>
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
