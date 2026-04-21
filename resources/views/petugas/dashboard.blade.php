@extends('layouts.app')
@section('title', 'Dashboard Petugas')
@section('content')
<style>
.page-title {
    margin-bottom: 28px;
}
.page-title h1 {
    font-size: 29px;
    font-weight: 700;
    color: #111827;
}
.page-title span {
    font-size: 14.5px;
    color: #6b7280;
}

/* ================= STATS - VERSI UPGRADE ================= */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(245px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-box {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 20px;
    padding: 24px 22px;
    display: flex;
    align-items: center;
    gap: 18px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.07);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #f1f5f9;
}
.stat-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
}
.stat-icon {
    width: 62px;
    height: 62px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    flex-shrink: 0;
}
.stat-info {
    flex: 1;
}
.stat-info h3 {
    margin: 0;
    font-size: 28px;
    font-weight: 700;
    color: #111827;
    line-height: 1;
}
.stat-info span {
    font-size: 13.5px;
    color: #64748b;
    font-weight: 500;
}
.trend {
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 4px;
    margin-top: 6px;
}
.trend.up { color: #10b981; }
.trend.down { color: #ef4444; }

/* Warna khusus tiap box */
.stat-total .stat-icon    { background: #f0f9ff; color: #0ea5e9; }
.stat-menunggu .stat-icon { background: #fefce8; color: #eab308; }
.stat-kembali .stat-icon  { background: #ecfdf5; color: #10b981; }
.stat-terlambat .stat-icon{ background: #fef2f2; color: #ef4444; }
</style>

<!-- TITLE -->
<div class="page-title">
    <h1>Dashboard Petugas</h1>
    <span>Ringkasan sistem peminjaman alat laboratorium</span>
</div>

<!-- ================= STATISTIK UPGRADE ================= -->
<div class="stats-grid">
    <!-- Total Alat -->
    <div class="stat-box stat-total">
        <div class="stat-icon"><i class="fa fa-boxes-stacked"></i></div>
        <div class="stat-info">
            <h3>{{ $totalAlat }}</h3>
            <span>Total Alat Tersedia</span>
            <div class="trend up">
                <i class="fa fa-arrow-trend-up"></i> +8% minggu ini
            </div>
        </div>
    </div>

    <!-- Menunggu Approval -->
    <div class="stat-box stat-menunggu">
        <div class="stat-icon"><i class="fa fa-clock"></i></div>
        <div class="stat-info">
            <h3>{{ $menunggu }}</h3>
            <span>Menunggu Approval</span>
            <div class="trend up">
                <i class="fa fa-arrow-trend-up"></i> {{ $menunggu > 0 ? 'Perlu ditangani' : 'Semua clear' }}
            </div>
        </div>
    </div>

    <!-- Dikembalikan Hari Ini -->
    <div class="stat-box stat-kembali">
        <div class="stat-icon"><i class="fa fa-rotate-left"></i></div>
        <div class="stat-info">
            <h3>{{ $pengembalianHariIni }}</h3>
            <span>Dikembalikan Hari Ini</span>
            <div class="trend {{ $pengembalianHariIni > 5 ? 'up' : 'down' }}">
                <i class="fa fa-arrow-trend-{{ $pengembalianHariIni > 5 ? 'up' : 'down' }}"></i>
                {{ $pengembalianHariIni }} transaksi
            </div>
        </div>
    </div>

    <!-- Terlambat -->
    <div class="stat-box stat-terlambat">
        <div class="stat-icon"><i class="fa fa-triangle-exclamation"></i></div>
        <div class="stat-info">
            <h3>{{ $terlambat }}</h3>
            <span>Peminjaman Terlambat</span>
            <div class="trend {{ $terlambat > 0 ? 'down' : '' }}">
                <i class="fa fa-arrow-trend-{{ $terlambat > 0 ? 'down' : 'up' }}"></i>
                {{ $terlambat > 0 ? 'Segera ditindak' : 'Tidak ada keterlambatan' }}
            </div>
        </div>
    </div>
</div>

<!-- ================= GRID (sama seperti sebelumnya) ================= -->
<div class="dashboard-grid">
    <!-- AKTIVITAS TERBARU -->
    <div class="card-box">
        <h3><i class="fa fa-clock-rotate-left"></i> Aktivitas Terbaru</h3>
        <ul class="list">
            @forelse($aktivitas as $item)
                <li>
                    <span>
                        {{ $item->alat->nama_alat ?? '-' }}
                        <small style="color:#6b7280;">— {{ $item->user->name ?? '-' }}</small>
                    </span>
                    <span class="badge
                        {{ $item->status == 'menunggu' ? 'wait' : '' }}
                        {{ in_array($item->status, ['dipinjam','approved']) ? 'done' : '' }}
                        {{ in_array($item->status, ['ditolak','rejected']) ? 'reject' : '' }}">
                        {{ ucfirst($item->status) }}
                    </span>
                </li>
            @empty
                <li>Tidak ada aktivitas saat ini</li>
            @endforelse
        </ul>
    </div>

    <!-- NOTIFIKASI -->
    <div class="card-box">
        <h3><i class="fa fa-bell"></i> Notifikasi Penting</h3>
        <ul class="list">
            <li>
                <span>Permintaan menunggu approval</span>
                <span class="badge wait">{{ $menunggu }} permintaan</span>
            </li>
            <li>
                <span>Peminjaman ditolak</span>
                <span class="badge reject">{{ $ditolak }} kasus</span>
            </li>
            <li>
                <span>Alat dengan stok rendah</span>
                <span class="badge info">{{ $stokRendah }} alat</span>
            </li>
            <li>
                <span>Peminjaman terlambat</span>
                <span class="badge reject">{{ $terlambat }} alat</span>
            </li>
        </ul>
    </div>
</div>

<!-- ================= ALAT POPULER + AKSI ================= -->
<div class="dashboard-grid">
    <div class="card-box">
        <h3><i class="fa fa-fire"></i> Alat Paling Sering Dipinjam</h3>
        <ul class="list">
            @forelse($alatPopuler as $alat)
                <li>
                    {{ $alat->nama_alat }}
                    <span class="badge done">{{ $alat->peminjaman_count }}x</span>
                </li>
            @empty
                <li>Tidak ada data</li>
            @endforelse
        </ul>
    </div>

    <div class="card-box">
        <h3><i class="fa fa-bolt"></i> Aksi Cepat Petugas</h3>
        <button class="btn btn-warning btn-quick">
            <i class="fa fa-file"></i> Generate Laporan
        </button>
        <button class="btn btn-danger btn-quick">
            <i class="fa fa-exclamation-triangle"></i> Cek Semua Terlambat
        </button>
    </div>
</div>

@endsection
