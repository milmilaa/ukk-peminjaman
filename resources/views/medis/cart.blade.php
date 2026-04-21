@extends('layouts.app')

@section('title','Keranjang')

@section('content')

@php
    $cart = $cart ?? [];
    $totalItem = count($cart);
    $totalQty = 0;

    foreach($cart as $c){
        $totalQty += $c['qty'] ?? 0;
    }
@endphp

<style>
.page-title {
    margin-bottom: 20px;
}

.page-title h1 {
    font-size: 26px;
    font-weight: 600;
}

.page-title span {
    font-size: 14px;
    color: #6b7280;
}

.cart-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

/* ================= LIST ================= */
.cart-list {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.cart-item {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
    align-items: center;
}

.cart-item img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 10px;
}

.cart-info {
    flex: 1;
}

.cart-info h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
}

.qty-control {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
}

.qty-btn {
    width: 28px;
    height: 28px;
    border: none;
    background: #eef1ff;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
}

.qty-number {
    min-width: 20px;
    text-align: center;
}

.btn-remove {
    background: #ef4444;
    color: white;
    border: none;
    padding: 7px 10px;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.2s;
}

.btn-remove:hover {
    background: #dc2626;
}

/* ================= SUMMARY ================= */
.summary {
    background: white;
    border-radius: 16px;
    padding: 20px;
    height: fit-content;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.summary h3 {
    margin-bottom: 15px;
}

.summary p {
    font-size: 14px;
    margin: 5px 0;
}

.btn-checkout {
    width: 100%;
    margin-top: 15px;
    background: linear-gradient(135deg,#3b4bff,#5f6fff);
    color: white;
    padding: 12px;
    border-radius: 10px;
    border: none;
    cursor: pointer;
    font-weight: 500;
}

.empty {
    text-align: center;
    color: #6b7280;
    padding: 20px;
}
</style>

{{-- ================= TITLE ================= --}}
<div class="page-title">
    <h1>Keranjang Saya</h1>
    <span>Daftar alat yang akan dipinjam</span>
</div>

<div class="cart-container">

    {{-- ================= LIST CART ================= --}}
    <div class="cart-list">

        @forelse($cart as $item)

        <div class="cart-item">

            <img src="{{ !empty($item['gambar']) ? asset('storage/'.$item['gambar']) : 'https://via.placeholder.com/150' }}">

            <div class="cart-info">
                <h4>{{ $item['nama_alat'] ?? 'Nama tidak tersedia' }}</h4>

                {{-- 🔥 QTY CONTROL --}}
                <div class="qty-control">

                    {{-- KURANG --}}
                    <form action="{{ route('medis.cart.decrease',$item['id']) }}" method="POST">
                        @csrf
                        <button class="qty-btn">-</button>
                    </form>

                    <div class="qty-number">
                        {{ $item['qty'] ?? 0 }}
                    </div>

                    {{-- TAMBAH --}}
                    <form action="{{ route('medis.cart.increase',$item['id']) }}" method="POST">
                        @csrf
                        <button class="qty-btn">+</button>
                    </form>

                </div>
            </div>

            {{-- HAPUS --}}
            <form action="{{ route('medis.cart.remove',$item['id']) }}" method="POST">
                @csrf
                <button class="btn-remove">
                    <i class="fa fa-trash"></i>
                </button>
            </form>

        </div>

        @empty
            <p class="empty">Keranjang kosong</p>
        @endforelse

    </div>

    {{-- ================= SUMMARY ================= --}}
    <div class="summary">

        <h3>Ringkasan</h3>

        <p>Total Jenis Barang: <b>{{ $totalItem }}</b></p>
        <p>Total Quantity: <b>{{ $totalQty }}</b></p>

        @if($totalItem > 0)
        <form action="{{ route('medis.peminjaman.store') }}" method="POST">
            @csrf
            <button class="btn-checkout">
                <i class="fa fa-check"></i> Ajukan Peminjaman
            </button>
        </form>
        @else
        <button class="btn-checkout" disabled style="background:#ccc;cursor:not-allowed;">
            Keranjang Kosong
        </button>
        @endif

    </div>

</div>

@endsection
