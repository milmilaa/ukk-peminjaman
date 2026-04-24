@extends('layouts.app')

@section('title','Dashboard Medis')

@section('content')

@php
    // Memastikan variable tidak null agar tidak error saat dilooping
    $alat = $alat ?? collect();
    $peminjaman = $peminjaman ?? collect();
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

*, *::before, *::after { box-sizing: border-box; }

:root {
    --bg: #f4f6fb;
    --card: #ffffff;
    --primary: #3b4bff;
    --primary-2: #5f6fff;
    --text: #111827;
    --muted: #6b7280;
    --border: #e5e7eb;
    --font: 'Plus Jakarta Sans', sans-serif;
}

body {
    background-color: var(--bg);
    font-family: var(--font);
    color: var(--text);
}

/* ── ALERT ── */
.alert {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-size: 14px;
    font-weight: 600;
    transition: 0.4s;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}
.alert.success { background: #ecfdf5; color: #047857; border: 1.5px solid #bbf7d0; }
.alert.error   { background: #fef2f2; color: #b91c1c; border: 1.5px solid #fecaca; }

/* ── TITLE ── */
.page-title { margin-bottom: 30px; }
.page-title h1 {
    font-size: 26px;
    font-weight: 800;
    color: var(--text);
    margin: 0;
}
.page-title span {
    font-size: 14px;
    color: var(--muted);
    display: block;
    margin-top: 5px;
}

/* ── PRODUCT GRID (Disamakan dengan Alat) ── */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 20px;
}

/* ── PRODUCT CARD (Disamakan dengan Alat) ── */
.product-card {
    background: var(--card);
    border-radius: 20px;
    overflow: hidden;
    border: 1.5px solid var(--border);
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 15px 30px rgba(59,75,255,0.15);
}

.product-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: #f3f4f6;
    border-bottom: 1px solid var(--border);
}

.product-body {
    padding: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    flex: 1;
}

.product-name {
    font-size: 16px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 4px;
    line-height: 1.2;
}

.stock-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 10px;
}

.stock { font-size: 13px; color: var(--muted); }

.status {
    font-size: 10px;
    padding: 3px 8px;
    border-radius: 999px;
    font-weight: 700;
    text-transform: uppercase;
}
.status.available { background: #dcfce7; color: #16a34a; }
.status.empty     { background: #fee2e2; color: #dc2626; }

.cart-btn {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    color: #fff;
    transition: 0.2s;
    margin-top: auto;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.cart-btn:hover:not(:disabled) {
    filter: brightness(1.1);
}

.cart-btn:disabled {
    background: #e2e8f0;
    color: #94a3b8;
    cursor: not-allowed;
}

/* ── RIWAYAT ACTIVITY CONTAINER ── */
.riwayat {
    margin-top: 45px;
    background: var(--card);
    border-radius: 20px;
    border: 1.5px solid var(--border);
    box-shadow: 0 4px 12px rgba(0,0,0,0.03);
    overflow: hidden;
    margin-bottom: 50px;
}

.riwayat-head {
    padding: 20px 24px;
    background: #fff;
    border-bottom: 1.5px solid var(--border);
    display: flex;
    align-items: center;
    gap: 12px;
}

.riwayat-head h3 {
    font-size: 18px;
    font-weight: 800;
    color: var(--text);
    margin: 0;
}

.riwayat-item {
    display: flex;
    gap: 20px;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    transition: background 0.2s;
}

.riwayat-item:hover { background: #f9fafb; }
.riwayat-item:last-child { border-bottom: none; }

.riwayat-num {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: #eef2ff;
    color: var(--primary);
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 13px;
    border: 1px solid #c7d2fe;
}

.riwayat-body { flex-grow: 1; }

.riwayat-title {
    font-size: 15px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 4px;
}

.riwayat-meta {
    font-size: 13px;
    color: var(--muted);
    margin-bottom: 12px;
    line-height: 1.6;
}

.riwayat-meta strong { color: #4b5563; font-weight: 600; }

.alat-list-box {
    background: #f9fafb;
    padding: 12px;
    border-radius: 10px;
    font-size: 12.5px;
    border: 1px solid var(--border);
    color: #4b5563;
}

.alat-list-box strong {
    display: block;
    margin-bottom: 5px;
    color: var(--text);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.alat-item-row {
    display: flex;
    justify-content: space-between;
    padding: 3px 0;
}

.status-container {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
    min-width: 110px;
}

.badge-status {
    padding: 6px 12px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

.badge-menunggu  { background: #fef9c3; color: #854d0e; border: 1px solid #fde047; }
.badge-disetujui { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
.badge-ditolak   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

.riwayat-empty {
    padding: 50px;
    text-align: center;
    color: var(--muted);
    font-size: 14px;
}
</style>

{{-- ================= ALERT ================= --}}
@if(session('success'))
<div class="alert success" id="alertBox">
    <i class="fa-solid fa-circle-check"></i>
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert error" id="alertBox">
    <i class="fa-solid fa-circle-xmark"></i>
    {{ session('error') }}
</div>
@endif

{{-- ================= HEADER ================= --}}
<div class="page-title">
    <h1>Dashboard Medis</h1>
    <span>Pantau stok alat dan riwayat peminjaman Anda</span>
</div>

{{-- ================= PRODUCT GRID ================= --}}
<div class="product-grid">
    @forelse($alat as $item)
        @php
            $stok = $item->stok ?? 0;
            $image = (!empty($item->gambar) && file_exists(storage_path('app/public/'.$item->gambar)))
                ? asset('storage/'.$item->gambar)
                : asset('images/no-image.png');
        @endphp

        <div class="product-card">
            <img src="{{ $image }}" class="product-img" alt="{{ $item->nama_alat }}" onerror="this.src='{{ asset('images/no-image.png') }}'">
            <div class="product-body">
                <div class="product-name">{{ $item->nama_alat }}</div>
                <div class="stock-row">
                    <span class="stock">Stok: <b>{{ $stok }}</b></span>
                    @if($stok > 0)
                        <span class="status available">Tersedia</span>
                    @else
                        <span class="status empty">Habis</span>
                    @endif
                </div>
                <form action="{{ route('medis.cart.add', $item->id) }}" method="POST">
                    @csrf
                    <button class="cart-btn" {{ $stok <= 0 ? 'disabled' : '' }}>
                        <i class="fa-solid fa-cart-plus"></i> Pinjam Alat
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div style="grid-column: 1/-1; padding: 50px; text-align: center; background: #fff; border-radius: 20px; border: 1.5px solid var(--border);">
            <p style="color: var(--muted); font-size: 15px; margin: 0;">Tidak ada alat medis yang tersedia.</p>
        </div>
    @endforelse
</div>

{{-- ================= RIWAYAT AKTIVITAS ================= --}}
<div class="riwayat">
    <div class="riwayat-head">
        <i class="fa-solid fa-clock-rotate-left" style="color: var(--primary); font-size: 20px;"></i>
        <h3>Riwayat Aktivitas Peminjaman</h3>
    </div>

    @forelse($peminjaman as $item)
    <div class="riwayat-item">
        <div class="riwayat-num">#{{ $item->id }}</div>

        <div class="riwayat-body">
            <div class="riwayat-title">Pengajuan Peminjaman</div>
            <div class="riwayat-meta">
                <span><strong>📅 Jadwal:</strong> {{ $item->tanggal_pinjam }} — {{ $item->tanggal_kembali }}</span><br>
                <span><strong>📌 Keperluan:</strong> {{ $item->keperluan ?? 'Tidak ada keterangan' }}</span>
            </div>

            <div class="alat-list-box">
                <strong>Daftar Alat:</strong>
                @foreach($item->detail as $d)
                    <div class="alat-item-row">
                        <span>{{ $d->alat->nama_alat }}</span>
                        <span style="font-weight: 700;">{{ $d->qty }} Unit</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="status-container">
            @if($item->status == 'menunggu')
                <span class="badge-status badge-menunggu">⏳ Menunggu</span>
            @elseif($item->status == 'disetujui')
                <span class="badge-status badge-disetujui">✅ Disetujui</span>
            @else
                <span class="badge-status badge-ditolak">❌ Ditolak</span>
            @endif
            <small style="color: var(--muted); font-size: 11px;">ID: {{ $item->id }}</small>
        </div>
    </div>
    @empty
        <div class="riwayat-empty">
            <i class="fa-solid fa-folder-open" style="font-size: 40px; color: #d1d5db; margin-bottom: 10px; display: block;"></i>
            <p>Belum ada riwayat aktivitas peminjaman.</p>
        </div>
    @endforelse
</div>

{{-- ================= JAVASCRIPT ================= --}}
<script>
// Menghilangkan alert otomatis
setTimeout(() => {
    let alert = document.getElementById('alertBox');
    if(alert){
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => alert.remove(), 500);
    }
}, 4000);
</script>

@endsection
