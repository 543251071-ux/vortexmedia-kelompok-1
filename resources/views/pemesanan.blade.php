<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan - VortexPlay</title>
    
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    
    <link rel="stylesheet" href="{{ asset('css/tampilan.css') }}">
</head>
<body>

    <div class="dashboard-container">
        
       
        <aside class="siderbar-menu">
            <div class="logo-container">
                <img src="image/Desain_Tanpa_Judul__2_-removebg-preview.png" alt="Logo" class="Image"> 
            </div>

            <div class="menu-items">
                <button type="button" class="nav-button">
                    <img src="image/user.png" alt="Pengguna" class="nav-icon">
                    <span>Pengguna</span>
                </button>
                <button type="button" class="nav-button active">
                    <img src="image/script.png" alt="Pemesanan" class="nav-icon">
                    <span>Pemesanan</span>
                </button>
                <button type="button" class="nav-button">
                    <img src="image/computer.png" alt="Komputer" class="nav-icon">
                    <span>Komputer</span>
                </button>
            </div>
        </aside>

        
        <div class="content-wrapper">
            
            
            <header class="top-header">
                <div class="user-profile">

                    <button type="button" class="btn-icon">
                        <img src="image/notification.png" alt="Notifikasi" class="header-icon">
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

            
            <main class="main-content">
                
                
                <div class="page-title">
                    <h1>Pemesanan</h1>
                    <p>Kelola semua data pemesanan pelanggan dengan mudah</p>
                </div>

                
                <section class="table-card">
                    <div class="card-header">
                        <h2>Pesanan Terbaru</h2>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama pelanggan</th>
                                    <th>Komputer</th>
                                    <th>durasi</th>
                                    <th>Status</th>
                                    <th>Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>Muhammad Zidan</td>
                                    <td>COMPUTER 01</td>
                                    <td>2 Jam</td>
                                    <td>Pending</td>
                                    <td>Rp10.000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

            </main>
        </div>

    </div>

    
    <script>
        const profileToggle = document.getElementById('profileToggle');
        const profileMenu = document.getElementById('profileMenu');
        const chevronIcon = document.getElementById('chevronIcon');

        profileToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            profileMenu.classList.toggle('show');
            chevronIcon.classList.toggle('rotate');
        });

        document.addEventListener('click', (e) => {
            if (!profileToggle.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.remove('show');
                chevronIcon.classList.remove('rotate');
            }
        });

        function logoutUser() {
            alert("Berhasil Log out!");
        }
    </script>

</body>
</html>