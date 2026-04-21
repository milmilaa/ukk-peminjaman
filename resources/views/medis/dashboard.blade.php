@extends('layouts.app')

@section('title','Dashboard Medis')

@section('content')

@php
    $alat = $alat ?? collect();
@endphp

<style>
/* ================= GLOBAL ================= */
body{
    background:#f5f7fb;
    font-family:'Segoe UI', sans-serif;
}

/* ================= TITLE ================= */
.page-title{
    margin-bottom:20px;
}

.page-title h1{
    font-size:26px;
    font-weight:700;
    color:#111827;
    margin:0;
}

.page-title span{
    font-size:14px;
    color:#6b7280;
}

/* ================= GRID ================= */
.product-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:18px;
}

/* ================= CARD ================= */
.product-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,0.06);
    transition:0.25s ease;
}

.product-card:hover{
    transform:translateY(-6px);
    box-shadow:0 12px 28px rgba(0,0,0,0.10);
}

/* ================= IMAGE ================= */
.product-img{
    width:100%;
    height:200px;
    object-fit:cover;
    background:#e5e7eb;
}

/* ================= BODY ================= */
.product-body{
    padding:14px;
}

.product-name{
    font-size:15px;
    font-weight:700;
    color:#111827;
    margin-bottom:6px;
}

/* STOCK */
.stock{
    font-size:12px;
    color:#6b7280;
    margin-bottom:6px;
}

/* STATUS */
.status{
    display:inline-block;
    font-size:11px;
    padding:4px 8px;
    border-radius:999px;
    font-weight:600;
}

.status.available{
    background:#dcfce7;
    color:#16a34a;
}

.status.empty{
    background:#fee2e2;
    color:#dc2626;
}

/* CART BUTTON */
.cart-btn{
    margin-top:10px;
    width:100%;
    padding:9px;
    border:none;
    border-radius:12px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
    background:#3b82f6;
    color:#fff;
    transition:0.2s;
}

.cart-btn:hover{
    background:#2563eb;
}

.cart-btn:disabled{
    background:#cbd5e1;
    cursor:not-allowed;
}

/* EMPTY */
.empty{
    text-align:center;
    padding:20px;
    color:#9ca3af;
}

/* RESPONSIVE */
@media(max-width:600px){
    .product-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .product-img{
        height:170px;
    }
}
</style>

<!-- TITLE -->
<div class="page-title">
    <h1>Daftar Alat Medis</h1>
    <span>Pilih alat dan masukkan ke keranjang</span>
</div>

<!-- GRID PRODUK -->
<div class="product-grid">

    @forelse($alat as $item)

        @php
            $stok = $item->jumlah ?? 0;

            // ================= FIX GAMBAR (SAMAKAN DENGAN INDEX) =================
            $image = $item->gambar
                ? asset('storage/'.$item->gambar)
                : asset('images/no-image.png');
        @endphp

        <div class="product-card">

            <img src="{{ $image }}" class="product-img">

            <div class="product-body">

                <!-- NAMA -->
                <div class="product-name">
                    {{ $item->nama_alat }}
                </div>

                <!-- STOK -->
                <div class="stock">
                    Stok: {{ $stok }}
                </div>

                <!-- STATUS -->
                @if($stok > 0)
                    <span class="status available">Tersedia</span>
                @else
                    <span class="status empty">Habis</span>
                @endif

                <!-- CART -->
                <form action="{{ route('medis.cart.add', $item->id) }}" method="POST">
                    @csrf
                    <button class="cart-btn" {{ $stok <= 0 ? 'disabled' : '' }}>
                        🛒 Tambah ke Keranjang
                    </button>
                </form>

            </div>
        </div>

    @empty
        <div class="empty">Tidak ada alat tersedia</div>
    @endforelse

</div>

@endsection
