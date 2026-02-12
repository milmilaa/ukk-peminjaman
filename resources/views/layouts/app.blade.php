<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Dashboard')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

    <style>
        * { font-family: 'Poppins', sans-serif; }
        body { margin: 0; background: #f4f7ff; }
        .wrapper { display: flex; height: 100vh; }

        .sidebar {
            width: 280px;
            background: #ffffff;
            border-right: 1px solid #e5e9ff;
            padding: 20px;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 20px;
            color: #3b4bff;
            margin-bottom: 30px;
        }

        .menu a, .menu summary {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            margin-bottom: 10px;
            border-radius: 14px;
            color: #555;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: .3s;
        }

        .menu a:hover, .menu summary:hover {
            background: #eef1ff;
            color: #3b4bff;
        }

        .menu a.active {
            background: #e5e9ff;
            color: #3b4bff;
            font-weight: 600;
        }

        .menu details summary { list-style: none; }
        .menu details summary::-webkit-details-marker { display: none; }

        .menu details summary::after {
            content: '\f107';
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            margin-left: auto;
        }

        .menu details a {
            margin-left: 26px;
            font-size: 14px;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: #ffffff;
            padding: 14px 25px;
            border-bottom: 1px solid #e5e9ff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-box {
            background: #f1f4ff;
            padding: 10px 18px;
            border-radius: 30px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 320px;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .profile img {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px solid #3b4bff;
        }

        .content {
            padding: 25px;
            flex: 1;
            overflow-y: auto;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <aside class="sidebar">
        <div class="brand">
            <i class="fa-solid fa-box-open"></i> Alat & Peminjaman
        </div>

        <nav class="menu">

            <a href="{{ route('dashboard') }}">
                <i class="fa-solid fa-house"></i> Dashboard
            </a>

            @if(auth()->user()->role === 'admin')

                <a href="{{ route('users.index') }}">
                    <i class="fa-solid fa-users"></i> User
                </a>

                <a href="{{ route('alat.index') }}">
                    <i class="fa-solid fa-box"></i> Alat
                </a>

                <a href="{{ route('kategori.index') }}">
                    <i class="fa-solid fa-layer-group"></i> Kategori
                </a>

                <details>
                    <summary>
                        <i class="fa-solid fa-file-lines"></i> Data
                    </summary>

                    <a href="{{ route('peminjaman.index') }}">
                        <i class="fa-solid fa-handshake"></i> Data Peminjaman
                    </a>

                    <a href="{{ route('pengembalian.index') }}">
                        <i class="fa-solid fa-rotate-left"></i> Data Pengembalian
                    </a>
                </details>

                <details>
                    <summary>
                        <i class="fa-solid fa-eye"></i> Monitoring
                    </summary>

                    <a href="{{ route('monitoring.log') }}">
                        <i class="fa-solid fa-clock-rotate-left"></i> Log Aktivitas
                    </a>
                </details>

            @endif

            @if(auth()->user()->role === 'petugas')

                <details>
                    <summary>
                        <i class="fa-solid fa-eye"></i> Monitoring
                    </summary>

                    <a href="{{ route('monitoring.menyetujui') }}">
                        <i class="fa-solid fa-circle-check"></i> Menyetujui Peminjaman
                    </a>

                    <a href="{{ route('monitoring.pengembalian') }}">
                        <i class="fa-solid fa-magnifying-glass-chart"></i> Memantau Pengembalian
                    </a>
                </details>

                <details>
                    <summary>
                        <i class="fa-solid fa-file-lines"></i> Laporan
                    </summary>

                    <a href="{{ route('laporan.cetak') }}">
                        <i class="fa-solid fa-print"></i> Cetak Laporan
                    </a>
                </details>

            @endif

            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>

        </nav>
    </aside>

    <div class="main">

        <div class="navbar">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Cari data...">
            </div>

            <div class="profile">
                <img src="https://i.pravatar.cc/150?img=3">
                <div>
                    <strong>{{ auth()->user()->name }}</strong><br>
                    <small>{{ auth()->user()->role }}</small>
                </div>
            </div>
        </div>

        <main class="content">
            @yield('content')
        </main>

    </div>

</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>

</body>
</html>
