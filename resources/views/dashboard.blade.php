@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@php
    $totalAlat = $totalAlat ?? 0;
    $peminjamanAktif = $peminjamanAktif ?? 0;
    $pengembalianHariIni = $pengembalianHariIni ?? 0;
    $totalPeminjaman = $totalPeminjaman ?? 0;
    $menunggu = $menunggu ?? 0;
    $ditolak = $ditolak ?? 0;
    $stokRendah = $stokRendah ?? 0;           // Tambahan baru
    $terlambat = $terlambat ?? 0;             // Tambahan ba    ru
    $aktivitas = $aktivitas ?? collect();
@endphp

<style>
/* ================= DASHBOARD STYLES ================= */
.page-title {
    margin-bottom: 32px;
}

.page-title h1 {
    font-size: 32px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.page-title span {
    font-size: 15px;
    color: #6b7280;
}

/* Stats Grid - Diperbesar sedikit */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(245px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
}

.stat-box {
    background: linear-gradient(145deg, #ffffff, #f8fafc);
    border-radius: 20px;
    padding: 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-box:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(59, 75, 255, 0.12);
}

.stat-icon {
    width: 58px;
    height: 58px;
    border-radius: 16px;
    background: #eef1ff;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3b4bff;
    font-size: 24px;
}

.stat-info h3 {
    font-size: 28px;
    margin: 0;
    font-weight: 700;
    color: #111827;
}

.stat-info span {
    font-size: 14px;
    color: #6b7280;
    font-weight: 500;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(340px, 1fr));
    gap: 26px;
}

.card {
    background: #ffffff;
    border-radius: 22px;
    padding: 26px;
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.07);
    height: fit-content;
}

.card h3 {
    font-size: 17.5px;
    font-weight: 600;
    margin-bottom: 22px;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Activity List */
.list-activity {
    list-style: none;
    padding: 0;
    margin: 0;
}

.list-activity li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 18px;
    margin-bottom: 10px;
    border-radius: 14px;
    background: #f8fafc;
    font-size: 14.5px;
    transition: 0.2s;
}

.list-activity li:hover {
    background: #f0f4ff;
}

/* Status Badge */
.status {
    font-size: 12.5px;
    padding: 6px 14px;
    border-radius: 9999px;
    font-weight: 600;
}

.status.wait   { background: #fff7e6; color: #f59e0b; }
.status.done   { background: #ecfdf5; color: #10b981; }
.status.reject { background: #fee2e2; color: #ef4444; }
.status.late   { background: #fee2e2; color: #b91c1c; }

.empty {
    text-align: center;
    color: #9ca3af;
    padding: 40px 20px;
    font-style: italic;
}
</style>

<!-- TITLE -->
<div class="page-title">
    <h1>Dashboard</h1>
    <span>Ringkasan aktivitas peminjaman dan pengelolaan alat medis</span>
</div>

<!-- STATS GRID -->
<div class="stats-grid">

    <div class="stat-box">
        <div class="stat-icon"><i class="fa-solid fa-box"></i></div>
        <div class="stat-info">
            <h3>{{ $totalAlat }}</h3>
            <span>Total Stok Alat</span>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon"><i class="fa-solid fa-handshake"></i></div>
        <div class="stat-info">
            <h3>{{ $peminjamanAktif }}</h3>
            <span>Peminjaman Aktif</span>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon"><i class="fa-solid fa-clock"></i></div>
        <div class="stat-info">
            <h3>{{ $menunggu }}</h3>
            <span>Menunggu Persetujuan</span>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon"><i class="fa-solid fa-rotate-left"></i></div>
        <div class="stat-info">
            <h3>{{ $pengembalianHariIni }}</h3>
            <span>Pengembalian Hari Ini</span>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon"><i class="fa-solid fa-xmark"></i></div>
        <div class="stat-info">
            <h3>{{ $ditolak }}</h3>
            <span>Peminjaman Ditolak</span>
        </div>
    </div>

    <!-- Fitur Tambahan -->
    <div class="stat-box">
        <div class="stat-icon" style="background:#fee2e2; color:#ef4444;">
            <i class="fa-solid fa-exclamation-triangle"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $stokRendah }}</h3>
            <span>Alat Stok Rendah</span>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon" style="background:#fee2e2; color:#b91c1c;">
            <i class="fa-solid fa-calendar-xmark"></i>
        </div>
        <div class="stat-info">
            <h3>{{ $terlambat }}</h3>
            <span>Peminjaman Terlambat</span>
        </div>
    </div>

</div>

<!-- DASHBOARD GRID -->
<div class="dashboard-grid">

    <!-- Aktivitas Peminjaman Terbaru -->
    <div class="card">
        <h3><i class="fa-solid fa-clock-rotate-left"></i> Aktivitas Terbaru</h3>
        <ul class="list-activity">
            @forelse($aktivitas as $item)
                <li>
                    <span>
                        {{ $item->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                        — {{ $item->user->name ?? 'User tidak ditemukan' }}
                    </span>
                    <span class="status
                        {{ $item->status == 'menunggu' ? 'wait' : '' }}
                        {{ $item->status == 'dipinjam' || $item->status == 'approved' ? 'done' : '' }}
                        {{ $item->status == 'ditolak' || $item->status == 'rejected' ? 'reject' : '' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </li>
            @empty
                <li class="empty">Belum ada aktivitas peminjaman</li>
            @endforelse
        </ul>
    </div>

    <!-- Notifikasi & Informasi -->
    <div class="card">
        <h3><i class="fa-solid fa-bell"></i> Notifikasi Sistem</h3>
        <ul class="list-activity">
            <li>📌 Ada <strong>{{ $menunggu }}</strong> peminjaman menunggu persetujuan</li>
            <li>📦 {{ $pengembalianHariIni }} alat telah dikembalikan hari ini</li>
            <li>⚠️ {{ $stokRendah }} alat memiliki stok rendah</li>
            <li>⏰ {{ $terlambat }} peminjaman terlambat pengembalian</li>
            <li>🧾 Laporan bulanan siap dicetak</li>
        </ul>
    </div>

</div>

@endsection
