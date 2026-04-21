<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALMEDIS - Peminjaman Alat Medis Internal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero-bg {
            background: linear-gradient(rgba(0, 48, 135, 0.85), rgba(0, 48, 135, 0.92)),
                        url('https://source.unsplash.com/random/2000x1300/?hospital,medical,operating-room') center/cover no-repeat;
        }
        .nav-scrolled {
            background-color: rgba(255, 255, 255, 0.98);
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        /* Kotak Menu Navigasi */
        .nav-menu {
            background-color: white;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
            border-radius: 9999px;
            padding: 8px 12px;
        }
        .nav-menu a {
            padding: 12px 24px;
            border-radius: 9999px;
            font-weight: 500;
            color: #374151;
            transition: all 0.3s ease;
        }
        .nav-menu a:hover {
            background-color: #f0fdfa;
            color: #00A8A8;
            box-shadow: 0 2px 8px rgba(0, 168, 168, 0.15);
        }
        .feature-card, .step-card {
            transition: all 0.4s ease;
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 168, 168, 0.18);
        }
        .step-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 20px -5px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body class="bg-zinc-50">

    <!-- Navbar -->
    <nav id="navbar" class="fixed top-0 w-full z-50 transition-all py-5">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center gap-x-3">
                    <div class="w-11 h-11 bg-[#003087] rounded-2xl flex items-center justify-center text-white font-bold text-4xl shadow">A</div>
                    <span class="text-3xl font-bold tracking-tighter text-[#003087]">ALMEDIS</span>
                </div>

                <!-- Menu Kotak (yang kamu minta) -->
                <div class="hidden md:flex nav-menu">
                    <a href="#kenapa">Kenapa Almedis</a>
                    <a href="#cara">Cara Pinjam</a>
                    <a href="#daftar">Daftar Alat</a>
                </div>

                <!-- Tombol Login -->
                <a href="{{ route('login') }}"
                   class="bg-[#003087] hover:bg-[#002266] text-white px-8 py-3 rounded-3xl text-sm font-semibold transition flex items-center gap-2">
                    <i class="fas fa-sign-in-alt"></i> Masuk
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero-bg min-h-screen flex items-center text-white">
        <div class="max-w-7xl mx-auto px-6 pt-20">
            <div class="max-w-2xl">
                <h1 class="text-5xl md:text-6xl font-semibold leading-tight tracking-tighter mb-6">
                    Pinjam Alat Medis<br>dengan Mudah & Cepat
                </h1>
                <p class="text-xl text-white/90 mb-10">
                    Platform internal khusus karyawan Rumah Sakit.<br>
                    Temukan, ajukan, dan pantau peminjaman alat medis dalam satu tempat.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#cara" class="bg-white text-[#003087] px-10 py-4 rounded-3xl font-semibold flex items-center gap-3 hover:bg-zinc-100 transition">
                        <i class="fas fa-arrow-right"></i> Mulai Pinjam Sekarang
                    </a>
                    <a href="#kenapa" class="border-2 border-white/80 hover:bg-white/10 px-10 py-4 rounded-3xl font-medium transition">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Kenapa Harus Almedis? -->
    <section id="kenapa" class="py-24 bg-white">
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl font-semibold text-center mb-16 text-zinc-800">Kenapa Harus Almedis?</h2>

            <div class="grid md:grid-cols-3 gap-10">
                <div class="feature-card bg-white border border-zinc-200 rounded-3xl p-10 text-center">
                    <div class="w-20 h-20 mx-auto bg-[#00A8A8] text-white rounded-2xl flex items-center justify-center mb-8">
                        <i class="fa-solid fa-magnifying-glass text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Cari Alat Instan</h3>
                    <p class="text-zinc-600 leading-relaxed">
                        Filter berdasarkan kategori, ruangan, atau nama alat. Lihat stok secara real-time.
                    </p>
                </div>

                <div class="feature-card bg-white border border-zinc-200 rounded-3xl p-10 text-center">
                    <div class="w-20 h-20 mx-auto bg-[#00A8A8] text-white rounded-2xl flex items-center justify-center mb-8">
                        <i class="fa-solid fa-clock text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Proses Cepat</h3>
                    <p class="text-zinc-600 leading-relaxed">
                        Ajukan peminjaman dalam 30 detik. Dapatkan persetujuan dari kepala ruangan atau bagian logistik.
                    </p>
                </div>

                <div class="feature-card bg-white border border-zinc-200 rounded-3xl p-10 text-center">
                    <div class="w-20 h-20 mx-auto bg-[#00A8A8] text-white rounded-2xl flex items-center justify-center mb-8">
                        <i class="fa-solid fa-history text-4xl"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Riwayat & Pengingat</h3>
                    <p class="text-zinc-600 leading-relaxed">
                        Pantau semua peminjaman Anda, notifikasi pengembalian, dan riwayat lengkap.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cara Pinjam -->
    <section id="cara" class="py-24 bg-zinc-100">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-semibold text-zinc-800">Cara Pinjam Alat di Almedis</h2>
                <p class="text-zinc-600 mt-3 text-lg">Hanya 4 langkah sederhana untuk meminjam alat medis</p>
            </div>

            <div class="grid md:grid-cols-4 gap-8">
                <div class="step-card bg-white border border-zinc-200 rounded-3xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-[#003087] text-white rounded-2xl flex items-center justify-center text-4xl font-bold mb-6">1</div>
                    <h4 class="font-semibold text-xl mb-3">Login Akun</h4>
                    <p class="text-zinc-600">Masuk menggunakan akun karyawan RS Anda</p>
                </div>

                <div class="step-card bg-white border border-zinc-200 rounded-3xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-[#003087] text-white rounded-2xl flex items-center justify-center text-4xl font-bold mb-6">2</div>
                    <h4 class="font-semibold text-xl mb-3">Cari Alat</h4>
                    <p class="text-zinc-600">Pilih alat yang dibutuhkan dan cek ketersediaan</p>
                </div>

                <div class="step-card bg-white border border-zinc-200 rounded-3xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-[#003087] text-white rounded-2xl flex items-center justify-center text-4xl font-bold mb-6">3</div>
                    <h4 class="font-semibold text-xl mb-3">Ajukan Pinjam</h4>
                    <p class="text-zinc-600">Isi tanggal pinjam & pengembalian + alasan penggunaan</p>
                </div>

                <div class="step-card bg-white border border-zinc-200 rounded-3xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto bg-[#003087] text-white rounded-2xl flex items-center justify-center text-4xl font-bold mb-6">4</div>
                    <h4 class="font-semibold text-xl mb-3">Tunggu Approval</h4>
                    <p class="text-zinc-600">Dapatkan notifikasi setelah disetujui oleh atasan / logistik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Siap Meminjam -->
    <section id="daftar" class="py-24 bg-white">
        <div class="max-w-5xl mx-auto px-6">
            <div class="bg-white border border-zinc-200 rounded-3xl shadow-xl p-16 text-center">
                <h2 class="text-4xl font-semibold text-zinc-800 mb-6">Siap Meminjam Alat Medis?</h2>
                <p class="text-xl text-zinc-600 mb-10 max-w-md mx-auto">
                    Ratusan alat medis siap dipinjam oleh karyawan rumah sakit
                </p>

                <a href="{{ route('medis.dashboard') }}"
   class="inline-flex items-center bg-[#003087] hover:bg-[#002266] text-white font-semibold text-xl px-14 py-7 rounded-3xl transition shadow-lg">
    Lihat Daftar Alat Tersedia
    <i class="ml-4 fa-solid fa-arrow-right"></i>
</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-zinc-900 text-zinc-400 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <div class="w-10 h-10 bg-white rounded-2xl flex items-center justify-center text-[#003087] font-bold text-4xl">A</div>
                <span class="text-3xl font-bold text-white tracking-tight">ALMEDIS</span>
            </div>
            <p class="text-sm">Sistem Peminjaman Alat Medis • Khusus Karyawan Rumah Sakit</p>
            <p class="text-xs mt-8 opacity-60">© 2026 ALMEDIS • Dikelola oleh Bagian Logistik & Sarana</p>
        </div>
    </footer>

    <script>
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 80) {
                navbar.classList.add('nav-scrolled', 'py-4');
            } else {
                navbar.classList.remove('nav-scrolled', 'py-4');
            }
        });
    </script>
</body>
</html>
