@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<style>

.page-title {
    margin-bottom: 30px;
}

.page-title h1 {
    font-size: 28px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 6px;
}

.page-title span {
    font-size: 14px;
    color: #6b7280;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 22px;
    margin-bottom: 35px;
}

.stat-box {
    background: linear-gradient(135deg, #ffffff, #f6f8ff);
    border-radius: 18px;
    padding: 22px;
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: 0 10px 30px rgba(59, 75, 255, 0.08);
    transition: all .35s ease;
    position: relative;
    overflow: hidden;
}

.stat-box::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent, rgba(59,75,255,.08), transparent);
    opacity: 0;
    transition: .35s;
}

.stat-box:hover::after {
    opacity: 1;
}

.stat-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 45px rgba(59, 75, 255, 0.18);
}

.stat-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: #eef1ff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #3b4bff;
    flex-shrink: 0;
}

.stat-info h3 {
    font-size: 26px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.stat-info span {
    font-size: 13px;
    color: #6b7280;
}

.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 25px;
}
.card {
    background: #ffffff;
    border-radius: 20px;
    padding: 22px 24px;
    box-shadow: 0 12px 35px rgba(0,0,0,.08);
    transition: all .35s ease;
}

.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 45px rgba(0,0,0,.12);
}

.card h3 {
    font-size: 17px;
    font-weight: 600;
    margin-bottom: 18px;
    color: #1f2937;
}

.list-activity {
    list-style: none;
    padding: 0;
    margin: 0;
}

.list-activity li {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    margin-bottom: 12px;
    border-radius: 14px;
    background: #f7f9ff;
    font-size: 14px;
    transition: .3s;
}

.list-activity li:hover {
    background: #eef1ff;
    transform: translateX(6px);
}

.list-activity li:last-child {
    margin-bottom: 0;
}

.status {
    font-size: 11px;
    padding: 5px 12px;
    border-radius: 30px;
    font-weight: 600;
    letter-spacing: .3px;
}

.status.wait {
    background: #fff7e6;
    color: #f59e0b;
}

.status.done {
    background: #ecfdf5;
    color: #10b981;
}

@media (max-width: 768px) {
    .page-title h1 {
        font-size: 24px;
    }

    .stat-info h3 {
        font-size: 22px;
    }
}
</style>

<div class="page-title">
    <h1>Dashboard</h1>
    <span>Ringkasan aktivitas peminjaman dan pengelolaan alat</span>
</div>

<div class="stats-grid">
    <div class="stat-box">
        <div class="stat-icon">
            <i class="fa-solid fa-box"></i>
        </div>
        <div class="stat-info">
            <h3>128</h3>
            <span>Total Alat</span>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon">
            <i class="fa-solid fa-handshake"></i>
        </div>
        <div class="stat-info">
            <h3>34</h3>
            <span>Peminjaman Aktif</span>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon">
            <i class="fa-solid fa-rotate-left"></i>
        </div>
        <div class="stat-info">
            <h3>17</h3>
            <span>Pengembalian Hari Ini</span>
        </div>
    </div>

    <div class="stat-box">
        <div class="stat-icon">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>6</h3>
            <span>Petugas Aktif</span>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <div class="card">
        <h3>Aktivitas Peminjaman Terbaru</h3>
        <ul class="list-activity">
            <li>
                <span>Laptop ASUS – Andi</span>
                <span class="status wait">Menunggu</span>
            </li>
            <li>
                <span>Proyektor Epson – Budi</span>
                <span class="status done">Disetujui</span>
            </li>
            <li>
                <span>Kamera Canon – Sinta</span>
                <span class="status done">Disetujui</span>
            </li>
        </ul>
    </div>

    <div class="card">
        <h3>Notifikasi Sistem</h3>
        <ul class="list-activity">
            <li>📌 Peminjaman baru menunggu persetujuan</li>
            <li>📦 Alat telah dikembalikan</li>
            <li>🧾 Laporan siap dicetak</li>
        </ul>
    </div>
</div>

@endsection
