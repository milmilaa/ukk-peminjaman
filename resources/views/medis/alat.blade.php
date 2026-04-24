@extends('layouts.app')

@section('title','Daftar Alat Medis')

@section('content')

@php
    $alat = $alat ?? collect();
@endphp

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

<style>
*, *::before, *::after { box-sizing: border-box; }

:root {
    --bg: #f4f6fb;
    --card: #ffffff;
    --primary: #3b4bff;
    --primary-2: #5f6fff;
    --text: #111827;
    --muted: #6b7280;
    --border: #e5e7eb;
}

/* ALERT */
.alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 13px 16px;
    border-radius: 12px;
    margin-bottom: 18px;
    font-size: 13.5px;
    font-weight: 600;
    transition: 0.4s;
}
.alert.success { background: #ecfdf5; color: #047857; border: 1.5px solid #bbf7d0; }
.alert.error   { background: #fef2f2; color: #b91c1c; border: 1.5px solid #fecaca; }

/* TITLE */
.page-title { margin-bottom: 25px; }
.page-title h1 {
    font-size: 26px;
    font-weight: 800;
    color: var(--text);
}
.page-title span {
    display: block;
    margin-top: 5px;
    font-size: 14px;
    color: var(--muted);
}

/* GRID */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); /* Gedein dikit lagi */
    gap: 20px;
}

/* CARD */
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
    height: 220px; /* Gambar dibikin lebih gede/tinggi */
    object-fit: cover;
    background: #f3f4f6;
    border-bottom: 1px solid var(--border);
}

.product-body {
    padding: 15px; /* Padding disesuaikan */
    display: flex;
    flex-direction: column;
    gap: 8px; /* GAP DIKECILIN biar nama alat & stok deketan */
}

.product-name {
    font-size: 16px;
    font-weight: 700;
    color: var(--text);
    margin: 0;
    line-height: 1.2;
    /* Menghapus min-height agar nempel ke bawah jika nama pendek */
}

.stock-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px; /* Kasih jarak dikit sebelum tombol */
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
</style>

<div class="page-title">
    <h1>Daftar Alat Medis</h1>
    <span>Pilih alat yang ingin dipinjam hari ini</span>
</div>

<div class="product-grid">

@forelse($alat as $item)

@php
    $stok = $item->stok ?? 0;

    if (!empty($item->gambar) && file_exists(storage_path('app/public/' . $item->gambar))) {
        $imageUrl = asset('storage/' . $item->gambar);
    } else {
        $imageUrl = asset('images/no-image.png');
    }
@endphp

<div class="product-card">
    <img src="{{ $imageUrl }}" class="product-img" onerror="this.src='{{ asset('images/no-image.png') }}'">

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
                <i class="fa-solid fa-cart-plus"></i> Pinjam
            </button>
        </form>
    </div>
</div>

@empty
    <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: #6b7280;">
        <i class="fa-solid fa-box-open" style="font-size: 50px; margin-bottom: 15px; display:block;"></i>
        <p>Tidak ada alat medis yang tersedia.</p>
    </div>
@endforelse

</div>

<script>
setTimeout(() => {
    let alert = document.getElementById('alertBox');
    if(alert){
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
</script>

@endsection
