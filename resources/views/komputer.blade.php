<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VORTEX PLAY - Manajemen Komputer</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        vortex: {
                            cyan: '#00c3f8',
                            cyanHover: '#33d3ff',
                            darkText: '#021724',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* Gaming Cyber Cafe Background Image dengan Cyan Tint */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #02121b;
            background-image: 
                linear-gradient(135deg, rgba(2, 18, 27, 0.88) 0%, rgba(6, 38, 56, 0.82) 50%, rgba(2, 14, 23, 0.92) 100%),
                url('https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: #ffffff;
            user-select: none;
        }

        /* Glassmorphic Panel Base */
        .glass-panel {
            background: rgba(6, 28, 42, 0.72);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border: 1px solid rgba(0, 195, 248, 0.22);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.08);
        }

        /* Glassmorphic PC Card */
        .glass-card {
            background: rgba(8, 40, 59, 0.65);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(0, 195, 248, 0.25);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.05);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-card:hover {
            border-color: rgba(0, 195, 248, 0.6);
            box-shadow: 0 8px 25px rgba(0, 195, 248, 0.2), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Modal Popup Animation */
        .dropdown-popup {
            animation: fadeInScale 0.2s ease-out forwards;
            transform-origin: center center;
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.92) translateY(-6px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(2, 18, 27, 0.5);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(0, 195, 248, 0.3);
            border-radius: 9999px;
        }
    </style>
</head>
<body class="relative min-h-screen flex items-center justify-center p-3 md:p-6 text-slate-100">

    <!-- Utama Dashboard Container -->
    <div class="relative z-10 w-full max-w-[1440px] min-h-[85vh] flex flex-col md:flex-row gap-5">
        
        <!-- ================= SIDEBAR ================= -->
        <aside class="glass-panel w-full md:w-64 lg:w-72 rounded-3xl p-6 flex flex-col justify-between shrink-0">
            <div>
                <!-- Brand Logo Header -->
                <div class="flex items-center gap-3 pb-8 pt-2">
                    <div class="w-10 h-10 rounded-xl bg-vortex-cyan/20 border border-vortex-cyan/60 flex items-center justify-center text-vortex-cyan shadow-[0_0_15px_rgba(0,195,248,0.4)]">
                        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                        </svg>
                    </div>
                    <span class="font-extrabold text-xl tracking-wider text-white">VORTEX PLAY</span>
                </div>

                <!-- Navigation Items -->
                <nav class="space-y-3">
                    <!-- Menu Item: Pengguna -->
                    <div class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl text-slate-300 opacity-80 cursor-pointer hover:bg-white/5 transition-all duration-200">
                        <i class="fa-regular fa-user text-xl w-6"></i>
                        <span class="font-semibold text-base">Pengguna</span>
                    </div>

                    <!-- Menu Item: Pemesanan -->
                    <div class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl text-slate-300 opacity-80 cursor-pointer hover:bg-white/5 transition-all duration-200">
                        <i class="fa-regular fa-rectangle-list text-xl w-6"></i>
                        <span class="font-semibold text-base">Pemesanan</span>
                    </div>

                    <!-- Menu Item: Komputer (Aktif Highlighted) -->
                    <div class="w-full flex items-center gap-4 px-4 py-3.5 rounded-2xl text-white bg-vortex-cyan/20 border border-vortex-cyan/50 shadow-[0_0_20px_rgba(0,195,248,0.2)] cursor-pointer">
                        <i class="fa-solid fa-desktop text-xl w-6 text-vortex-cyan"></i>
                        <span class="font-bold text-base">Komputer</span>
                    </div>
                </nav>
            </div>

            <!-- Bottom Status System Badge -->
            <div class="pt-6 border-t border-white/10 mt-6 hidden md:block">
                <div class="bg-black/30 rounded-2xl p-4 border border-white/5">
                    <div class="text-xs text-slate-400 font-medium">Status Sistem</div>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-sm font-semibold text-emerald-400 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)]"></span> Online
                        </span>
                        <span class="text-xs text-slate-400 font-mono">v2.4.0</span>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ================= MAIN CONTENT AREA (HALAMAN KOMPUTER) ================= -->
        <main class="glass-panel flex-1 rounded-3xl p-6 md:p-8 flex flex-col justify-between">
            
            <div>
                <!-- Header Bar -->
                <header class="flex items-center justify-between pb-6 mb-8 border-b border-white/10">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-wide">Komputer</h1>
                        <p class="text-slate-400 text-xs md:text-sm mt-1">Pantau komputer yang tersedia dengan lebih efisien</p>
                    </div>

                    <!-- Admin Widget & Notification Bell -->
                    <div class="flex items-center gap-4">
                        <!-- Bell Notification Button -->
                        <button onclick="toggleNotifModal()" class="relative w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:text-white hover:bg-white/10 transition-all">
                            <i class="fa-regular fa-bell text-lg"></i>
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-vortex-cyan rounded-full border-2 border-[#062638]"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notif-dropdown" class="hidden absolute top-20 right-28 w-72 glass-panel rounded-2xl p-4 z-50 border border-vortex-cyan/30 shadow-2xl dropdown-popup">
                            <div class="flex justify-between items-center pb-2 border-b border-white/10 mb-2">
                                <span class="font-bold text-xs text-white">Notifikasi</span>
                                <span class="text-[10px] text-vortex-cyan cursor-pointer" onclick="toggleNotifModal()">Tutup</span>
                            </div>
                            <p class="text-xs text-slate-300">Semua komputer dalam kondisi normal.</p>
                        </div>

                        <!-- Divider Line -->
                        <div class="h-6 w-[1px] bg-white/15"></div>

                        <!-- Admin Profile Badge -->
                        <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-2xl px-3 py-1.5">
                            <div class="w-8 h-8 rounded-full bg-slate-700 overflow-hidden border border-vortex-cyan/50 flex items-center justify-center">
                                <i class="fa-solid fa-user text-slate-300 text-sm"></i>
                            </div>
                            <div class="text-left hidden sm:block">
                                <div class="text-xs font-bold leading-tight text-white">admin</div>
                                <div class="text-[10px] text-slate-400 leading-tight">Administrator</div>
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 ml-1"></i>
                        </div>
                    </div>
                </header>

                <!-- PC CARDS GRID (LANGSUNG TAMPIL 4 KARTU KOMPUTER) -->
                <div id="computer-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Cards diproduksi secara dinamis via JavaScript -->
                </div>
            </div>

            <!-- Bottom Center Watermark Logo -->
            <div class="mt-12 text-center pb-2">
                <div class="text-slate-500/40 font-extrabold text-xl tracking-[0.25em] select-none">VORTEX PLAY</div>
            </div>

        </main>
    </div>

    <!-- ================= MODAL DIALOG "PILIH STATUS" ================= -->
    <div id="status-modal-overlay" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
        <div id="status-modal-card" class="glass-panel w-full max-w-xs rounded-3xl p-5 border border-vortex-cyan/60 shadow-[0_0_40px_rgba(0,195,248,0.25)] dropdown-popup">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-white/10">
                <h3 class="text-sm font-bold text-white tracking-wide">Pilih Status</h3>
                <button onclick="closeStatusModal()" class="text-slate-400 hover:text-white text-base w-7 h-7 flex items-center justify-center rounded-lg hover:bg-white/10 transition">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Target Computer Title -->
            <div id="target-pc-label" class="text-xs text-vortex-cyan font-bold tracking-wider mb-3">KOMPUTER 01</div>

            <!-- Status Options list -->
            <div class="space-y-2">
                <!-- Option: Kosong -->
                <button onclick="selectStatus('Kosong')" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-vortex-cyan/20 border border-white/5 hover:border-vortex-cyan/50 transition-all text-left group">
                    <span class="w-3.5 h-3.5 rounded-full bg-slate-400 group-hover:scale-125 transition-transform"></span>
                    <span class="text-sm font-semibold text-slate-200 group-hover:text-white">Kosong</span>
                </button>

                <!-- Option: Tersedia -->
                <button onclick="selectStatus('Tersedia')" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-vortex-cyan/20 border border-white/5 hover:border-vortex-cyan/50 transition-all text-left group">
                    <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(34,197,94,0.8)] group-hover:scale-125 transition-transform"></span>
                    <span class="text-sm font-semibold text-slate-200 group-hover:text-white">Tersedia</span>
                </button>

                <!-- Option: Terpakai -->
                <button onclick="selectStatus('Terpakai')" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-vortex-cyan/20 border border-white/5 hover:border-vortex-cyan/50 transition-all text-left group">
                    <span class="w-3.5 h-3.5 rounded-full bg-rose-500 shadow-[0_0_8px_rgba(239,68,68,0.8)] group-hover:scale-125 transition-transform"></span>
                    <span class="text-sm font-semibold text-slate-200 group-hover:text-white">Terpakai</span>
                </button>

                <!-- Option: Dipesan -->
                <button onclick="selectStatus('Dipesan')" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl bg-white/5 hover:bg-vortex-cyan/20 border border-white/5 hover:border-vortex-cyan/50 transition-all text-left group">
                    <span class="w-3.5 h-3.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)] group-hover:scale-125 transition-transform"></span>
                    <span class="text-sm font-semibold text-slate-200 group-hover:text-white">Dipesan</span>
                </button>
            </div>
        </div>
    </div>


    <!-- ================= LOGIK JAVASCRIPT ================= -->
    <script>
        // Data 4 Komputer
        const computers = [
            { id: 1, name: 'KOMPUTER 01', status: 'Kosong' },
            { id: 2, name: 'KOMPUTER 02', status: 'Kosong' },
            { id: 3, name: 'KOMPUTER 03', status: 'Kosong' },
            { id: 4, name: 'KOMPUTER 04', status: 'Kosong' }
        ];

        let activeTargetPcId = null;

        // Configuration Warna Status
        const statusConfig = {
            'Kosong': {
                dotColor: 'bg-slate-400',
                textColor: 'text-slate-300'
            },
            'Tersedia': {
                dotColor: 'bg-emerald-500 shadow-[0_0_8px_rgba(34,197,94,0.8)]',
                textColor: 'text-emerald-400'
            },
            'Terpakai': {
                dotColor: 'bg-rose-500 shadow-[0_0_8px_rgba(239,68,68,0.8)]',
                textColor: 'text-rose-400'
            },
            'Dipesan': {
                dotColor: 'bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.8)]',
                textColor: 'text-amber-400'
            }
        };

        // Render Komputer ke Grid UI
        function renderComputers() {
            const grid = document.getElementById('computer-grid');
            grid.innerHTML = '';

            computers.forEach(pc => {
                const config = statusConfig[pc.status] || statusConfig['Kosong'];

                const cardHtml = `
                    <div class="glass-card rounded-2xl p-6 flex flex-col items-center text-center relative group">
                        
                        <!-- Vector Graphic Monitor + PC Case SVG -->
                        <div class="w-full flex justify-center pt-2 pb-5">
                            <div class="text-white/95 group-hover:scale-105 transition-transform duration-300">
                                <svg class="w-24 h-20" viewBox="0 0 100 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="5" y="5" width="55" height="42" rx="4" stroke="currentColor" stroke-width="4.5" fill="none"/>
                                    <rect x="10" y="10" width="45" height="32" rx="2" fill="currentColor" fill-opacity="0.15"/>
                                    <path d="M32.5 47V58" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/>
                                    <path d="M20 58H45" stroke="currentColor" stroke-width="4.5" stroke-linecap="round"/>
                                    <rect x="68" y="5" width="24" height="53" rx="4" stroke="currentColor" stroke-width="4.5" fill="none"/>
                                    <circle cx="80" cy="14" r="2.5" fill="currentColor"/>
                                    <line x1="74" y1="23" x2="86" y2="23" stroke="currentColor" stroke-width="3" stroke-linecap="round"/>
                                </svg>
                            </div>
                        </div>

                        <!-- Nama PC & Status Dot -->
                        <div class="w-full pt-1 pb-4">
                            <div class="flex items-center justify-center gap-2">
                                <h3 class="font-extrabold text-base text-white tracking-wide">${pc.name}</h3>
                                <span class="w-2.5 h-2.5 rounded-full ${config.dotColor}"></span>
                            </div>
                            
                            <div class="flex items-center justify-center gap-1.5 mt-1.5 text-xs">
                                <span class="text-slate-400 font-medium">Status</span>
                                <span class="font-bold tracking-wider uppercase ${config.textColor}">${pc.status}</span>
                            </div>
                        </div>

                        <!-- Tombol UBAH -->
                        <button onclick="openStatusModal(${pc.id})" class="w-full py-2.5 px-4 rounded-xl bg-vortex-cyan hover:bg-vortex-cyanHover text-vortex-darkText font-extrabold text-xs uppercase tracking-wider transition-all duration-200 shadow-[0_4px_15px_rgba(0,195,248,0.35)] active:scale-95">
                            UBAH
                        </button>
                    </div>
                `;
                grid.innerHTML += cardHtml;
            });
        }

        // Fungsi Buka & Tutup Modal
        function openStatusModal(pcId) {
            activeTargetPcId = pcId;
            const targetPc = computers.find(pc => pc.id === pcId);
            if (targetPc) {
                document.getElementById('target-pc-label').innerText = `${targetPc.name}`;
                document.getElementById('status-modal-overlay').classList.remove('hidden');
            }
        }

        function closeStatusModal() {
            document.getElementById('status-modal-overlay').classList.add('hidden');
            activeTargetPcId = null;
        }

        function selectStatus(newStatus) {
            if (activeTargetPcId !== null) {
                const pcIndex = computers.findIndex(pc => pc.id === activeTargetPcId);
                if (pcIndex !== -1) {
                    computers[pcIndex].status = newStatus;
                    renderComputers();
                }
            }
            closeStatusModal();
        }

        function toggleNotifModal() {
            document.getElementById('notif-dropdown').classList.toggle('hidden');
        }

        // Tutup Modal ketika area luar diklik
        document.getElementById('status-modal-overlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStatusModal();
            }
        });

        // Inisialisasi awal saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            renderComputers();
        });
    </script>
</body>
</html>