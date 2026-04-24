<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard - ALMEDIS')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    @php $authUser = auth()->user(); @endphp
    @if($authUser && in_array($authUser->role, ['admin', 'petugas']))
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endif

    <style>
        :root {
            --primary: #3b4bff;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }
        body {
            margin: 0;
            background: #f8fafc;
            transition: background 0.3s;
        }
        .wrapper {
            display: flex;
            height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 285px;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            padding: 28px 0;
            box-shadow: 4px 0 20px rgba(59, 75, 255, 0.1);
            transition: all 0.4s ease;
            overflow-y: auto;
        }

        .brand {
            font-weight: 700;
            font-size: 27px;
            background: linear-gradient(135deg, #3b4bff, #6b7cff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 50px;
            padding: 0 28px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 28px;
            margin: 6px 16px;
            border-radius: 16px;
            text-decoration: none;
            color: #64748b;
            font-weight: 500;
            font-size: 15.2px;
            transition: all 0.3s ease;
        }

        .menu a:hover {
            background: #f0f4ff;
            color: var(--primary);
            transform: translateX(8px);
        }

        .menu a.active {
            background: #e0e7ff;
            color: var(--primary);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(59, 75, 255, 0.18);
        }

        .menu a.logout {
            color: #ef4444;
            margin-top: 12px;
        }
        .menu a.logout:hover {
            background: #fee2e2;
            color: #b91c1c;
            transform: translateX(8px) scale(1.03);
        }

        .menu-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #cbd5e1, transparent);
            margin: 26px 28px;
        }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: #ffffff;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
        }

        .search-filter-container {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .search-box {
            background: #f1f5f9;
            padding: 12px 22px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 360px;
            transition: all 0.3s;
        }
        .search-box:hover {
            background: #e8eef9;
            box-shadow: 0 2px 8px rgba(59, 75, 255, 0.1);
        }
        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            font-size: 15.5px;
            color: #475569;
        }

        /* FILTER BAR */
        .filter-bar {
            background: #ffffff;
            padding: 18px 30px;
            border-radius: 18px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.06);
            margin: 24px 30px 0;
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
            white-space: nowrap;
        }

        .filter-bar::-webkit-scrollbar {
            height: 6px;
        }
        .filter-bar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .filter-input {
            padding: 13px 18px;
            border: 1.5px solid #e2e8f0;
            border-radius: 14px;
            background: #fff;
            font-size: 14.8px;
            min-width: 175px;
        }

        .btn-filter {
            padding: 13px 24px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 9px;
            transition: all 0.3s;
            flex-shrink: 0;
        }
        .btn-filter:hover {
            background: #2f3de6;
            transform: translateY(-2px);
        }

        .btn-refresh {
            padding: 13px 24px;
            background: #64748b;
            color: white;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            flex-shrink: 0;
        }
        .btn-refresh:hover {
            background: #475569;
            transform: translateY(-2px);
        }

        /* RIGHT NAV */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 22px;
        }

        .nav-icon {
            position: relative;
            cursor: pointer;
            font-size: 24px;
            color: #64748b;
            transition: 0.25s;
        }
        .nav-icon:hover {
            color: var(--primary);
            transform: scale(1.1);
        }

        .badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ef4444;
            color: #fff;
            font-size: 10.5px;
            padding: 2px 7px;
            border-radius: 50%;
            font-weight: 700;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 16px;
            transition: 0.3s;
        }
        .profile:hover {
            background: #f0f4ff;
        }
        .profile img {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: 3px solid var(--primary);
            object-fit: cover;
        }

        .content {
            padding: 30px;
            flex: 1;
            overflow: auto;
        }

        /* DARK MODE */
        body.dark-mode {
            background: #1a1f36;
        }
        body.dark-mode .sidebar,
        body.dark-mode .navbar,
        body.dark-mode .filter-bar,
        body.dark-mode .modal-box {
            background: #222a4a;
            color: #e0e7ff;
            border-color: #33415e;
        }
        body.dark-mode .menu a { color: #cbd5e1; }
        body.dark-mode .search-box,
        body.dark-mode .filter-input {
            background: #2a3559;
            border-color: #475569;
        }
        body.dark-mode .search-box input,
        body.dark-mode .filter-input { color: #e0e7ff; }

        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-box {
            background: #fff;
            padding: 34px;
            border-radius: 20px;
            width: 400px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        }

        .hamburger {
            display: none;
            font-size: 28px;
            cursor: pointer;
            color: var(--primary);
        }

        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -300px;
                top: 0;
                height: 100%;
                z-index: 999;
                box-shadow: 8px 0 25px rgba(0,0,0,0.2);
            }
            .sidebar.active { left: 0; }
            .hamburger { display: block; }
        }
    </style>
</head>

<body>

@php
    $user = auth()->user();
    $cart = session('cart', []);
    $cartCount = is_array($cart) ? array_sum(array_column($cart, 'qty')) : 0;

    $role = $user ? strtolower($user->role) : null;

    $isAdmin = $role === 'admin';
    $isPetugas = $role === 'petugas';
    $isMedis = $role === 'medis';

    // 🔥 Ambil jumlah notif belum dibaca
    $unreadNotifCount = 0;
    if($user) {
        $unreadNotifCount = \App\Models\Notif::where('user_id', $user->id)
                            ->where('is_read', false)
                            ->count();
    }
@endphp

<div class="wrapper">

    <aside class="sidebar" id="sidebar">
        <div class="brand">
            <i class="fa-solid fa-box-open"></i>
            <span>ALMEDIS</span>
        </div>

        <nav class="menu">

            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>

            @if($isAdmin)
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}"><i class="fa-solid fa-users"></i> Manajemen User</a>
            <a href="{{ route('admin.alat.index') }}" class="{{ request()->routeIs('admin.alat.*') ? 'active' : '' }}"><i class="fa-solid fa-microscope"></i> Data Alat</a>
            <a href="{{ route('admin.kategori.index') }}" class="{{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"><i class="fa-solid fa-tags"></i> Kategori</a>

            <div class="menu-divider"></div>

            <a href="{{ route('admin.peminjaman.index') }}" class="{{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}"><i class="fa-solid fa-hand-holding-medical"></i> Peminjaman</a>
            <a href="{{ route('admin.pengembalian.index') }}" class="{{ request()->routeIs('admin.pengembalian.*') ? 'active' : '' }}"><i class="fa-solid fa-rotate-left"></i> Pengembalian</a>
            <a href="{{ route('admin.monitoring.log') }}" class="{{ request()->routeIs('admin.monitoring.log') ? 'active' : '' }}"><i class="fa-solid fa-clock-rotate-left"></i> Log Aktivitas</a>
            @endif

            @if($isPetugas)
            <div class="menu-divider"></div>

            <div style="padding:0 28px;font-size:12px;color:#94a3b8;font-weight:600;">
            MENU PETUGAS
            </div>

            <a href="{{ route('petugas.menyetujui') }}" class="{{ request()->routeIs('petugas.menyetujui') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> Aktivitas Peminjaman
            </a>

            <a href="{{ route('petugas.pengembalian') }}" class="{{ request()->routeIs('petugas.pengembalian') ? 'active' : '' }}">
                <i class="fa-solid fa-arrow-rotate-left"></i> Monitoring Pengembalian
            </a>

            <a href="{{ route('petugas.cetak.peminjaman') }}" class="{{ request()->routeIs('petugas.cetak.peminjaman') ? 'active' : '' }}">
                <i class="fa-solid fa-print"></i> Cetak Laporan
            </a>
            @endif

            @if($isMedis)
            <div class="menu-divider"></div>

            <a href="{{ route('medis.alat') }}" class="{{ request()->routeIs('medis.alat') ? 'active' : '' }}">
                <i class="fa-solid fa-stethoscope"></i> Daftar Alat
            </a>

            <a href="{{ route('medis.aktivitas') }}" class="{{ request()->routeIs('medis.aktivitas') ? 'active' : '' }}">
                <i class="fa-solid fa-list-check"></i> Riwayat Aktivitas
            </a>
            @endif

            @if($user)
            <div class="menu-divider"></div>
            <a href="{{ route('logout') }}" class="logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
            @endif

        </nav>
    </aside>

    <div class="main">

        <div class="navbar">
            <div class="search-filter-container">
                <span class="hamburger" onclick="toggleSidebar()">
                    <i class="fa-solid fa-bars"></i>
                </span>
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="searchInput" placeholder="Cari alat atau peminjaman..."
                           onkeypress="if(event.key === 'Enter') applyFilters()">
                </div>
            </div>

            <div class="nav-right">
                @if($isMedis)
                <div class="nav-icon" onclick="window.location='{{ route('medis.cart') }}'">
                    <i class="fa-solid fa-cart-shopping"></i>
                    @if($cartCount > 0)
                        <span class="badge">{{ $cartCount }}</span>
                    @endif
                </div>
                @endif

                {{-- 🔥 Icon Notif dengan Badge Dinamis --}}
                <div class="nav-icon" onclick="window.location='{{ route('notif.page') }}'">
                    <i class="fa-solid fa-bell"></i>
                    @if($unreadNotifCount > 0)
                        <span class="badge">{{ $unreadNotifCount }}</span>
                    @endif
                </div>

                <div class="nav-icon" onclick="toggleDarkMode()" id="darkModeIcon">
                    <i class="fa-solid fa-moon"></i>
                </div>

                <div class="nav-icon" onclick="toggleFullscreen()">
                    <i class="fa-solid fa-expand"></i>
                </div>

                @if($user)
                <div class="profile" onclick="openProfileModal()">
                    <img src="{{ $user->foto ? asset($user->foto) : 'https://i.pravatar.cc/150?img=3' }}" alt="Profile">
                    <div>
                        <b>{{ $user->name }}</b><br>
                        <small style="color:#666;">{{ ucfirst($user->role) }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if($isAdmin || $isPetugas)
        <div class="filter-bar">
            <input type="text" id="dateFrom" class="filter-input" placeholder="Tanggal Peminjaman">
            <input type="text" id="dateTo" class="filter-input" placeholder="Tanggal Pengembalian">

            <select id="statusFilter" class="filter-input">
                <option value="">Semua Status</option>
                <option value="pending">Pending</option>
                <option value="approved">Disetujui</option>
                <option value="rejected">Ditolak</option>
                <option value="completed">Selesai</option>
            </select>

            <button class="btn-filter" onclick="applyFilters()">
                <i class="fa-solid fa-filter"></i> Terapkan
            </button>

            <button class="btn-refresh" onclick="refreshPage()">
                <i class="fa-solid fa-rotate-right"></i> Refresh
            </button>

            @if($isPetugas)
            <button class="btn-filter" style="background:#10b981;" onclick="exportExcel()">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </button>
            <button class="btn-filter" style="background:#d97706;" onclick="exportPDF()">
                <i class="fa-solid fa-file-pdf"></i> Export PDF
            </button>
            @endif
        </div>
        @endif

        <main class="content">
            @yield('content')
        </main>
    </div>
</div>

<div class="modal" id="profileModal">
    <div class="modal-box">
        @if($user)
            <img src="{{ $user->foto ? asset($user->foto) : 'https://i.pravatar.cc/150?img=3' }}" id="previewImg" style="width:120px; height:120px; margin-bottom:20px; border-radius:50%; object-fit: cover;">

            <h3>{{ $user->name }}</h3>
            <p style="color:#64748b; margin-bottom:25px;">{{ $user->email }}</p>

            <form action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="foto" accept="image/*" onchange="preview(event)" style="margin:15px 0;">

                <div style="display:flex; gap:12px; margin-top:25px;">
                    <button type="button" onclick="closeProfileModal()"
                            style="flex:1; padding:13px; background:#f1f5f9; border:none; border-radius:12px; cursor:pointer;">
                        Tutup
                    </button>
                    <button type="submit"
                            style="flex:1; padding:13px; background:var(--primary); color:white; border:none; border-radius:12px; cursor:pointer;">
                        Simpan Foto
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('active');
}

function openProfileModal() {
    document.getElementById('profileModal').style.display = 'flex';
}

function closeProfileModal() {
    document.getElementById('profileModal').style.display = 'none';
}

function preview(event) {
    let reader = new FileReader();
    reader.onload = function() {
        document.getElementById('previewImg').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}

function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const icon = document.getElementById('darkModeIcon');
    if (document.body.classList.contains('dark-mode')) {
        icon.innerHTML = '<i class="fa-solid fa-sun"></i>';
        localStorage.setItem('darkMode', 'true');
    } else {
        icon.innerHTML = '<i class="fa-solid fa-moon"></i>';
        localStorage.setItem('darkMode', 'false');
    }
}

function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
    } else {
        document.exitFullscreen();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    @if($isAdmin || $isPetugas)
    flatpickr("#dateFrom", { dateFormat: "Y-m-d" });
    flatpickr("#dateTo",   { dateFormat: "Y-m-d" });
    @endif

    if (localStorage.getItem('darkMode') === 'true') {
        document.body.classList.add('dark-mode');
        document.getElementById('darkModeIcon').innerHTML = '<i class="fa-solid fa-sun"></i>';
    }
});

function applyFilters() {
    const search = document.getElementById('searchInput').value.trim();
    let url = window.location.pathname + '?';

    if (search) url += `search=${encodeURIComponent(search)}&`;

    @if($isAdmin || $isPetugas)
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo   = document.getElementById('dateTo').value;
    const status   = document.getElementById('statusFilter').value;

    if (dateFrom) url += `from=${dateFrom}&`;
    if (dateTo)   url += `to=${dateTo}&`;
    if (status)   url += `status=${status}&`;
    @endif

    window.location.href = url.slice(0, -1);
}

function refreshPage() {
    window.location.reload();
}

function exportExcel() {
    window.location.href = '{{ route("petugas.peminjaman.export.excel") }}';
}

function exportPDF() {
    alert('Fitur Export PDF sedang dalam pengembangan.');
}
</script>

</body>
</html>
