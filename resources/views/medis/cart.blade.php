@extends('layouts.app')

@section('title','Keranjang')

@section('content')

@php
    $cart = $cart ?? [];
@endphp

{{-- ✅ ALERT SUKSES --}}
@if(session('success'))
<div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:15px;">
    {{ session('success') }}
</div>
@endif

<style>
.page-title { margin-bottom: 20px; }
.page-title h1 { font-size: 26px; font-weight: 600; }
.page-title span { font-size: 14px; color: #6b7280; }

.cart-container {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 20px;
}

/* LIST */
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

.cart-info { flex: 1; }

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
}

.btn-remove {
    background: #ef4444;
    color: white;
    border: none;
    padding: 7px 10px;
    border-radius: 8px;
    cursor: pointer;
}

/* SUMMARY + FORM */
.summary {
    background: white;
    border-radius: 16px;
    padding: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
}

.summary h3 {
    margin-bottom: 15px;
}

.form-group {
    margin-bottom: 12px;
}

.form-group label {
    font-size: 13px;
    font-weight: 500;
    display: block;
    margin-bottom: 4px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    font-size: 13px;
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
}

.empty {
    text-align: center;
    color: #6b7280;
    padding: 20px;
}
</style>

<div class="page-title">
    <h1>Keranjang Saya</h1>
    <span>Pilih alat & isi form peminjaman</span>
</div>

<form action="{{ route('medis.peminjaman.store') }}" method="POST">
@csrf

<div class="cart-container">

    {{-- ================= LIST ================= --}}
    <div class="cart-list">

        @forelse($cart as $item)

        @php
            $image = (!empty($item['gambar']) && file_exists(public_path('storage/'.$item['gambar'])))
                ? asset('storage/'.$item['gambar'])
                : asset('images/no-image.png');
        @endphp

        <div class="cart-item">

            {{-- CHECKBOX --}}
            <input type="checkbox" name="selected_items[]" value="{{ $item['id'] }}" class="check-item">

            <img src="{{ $image }}">

            <div class="cart-info">
                <h4>{{ $item['nama_alat'] }}</h4>

                <div class="qty-control">
                    <form action="{{ route('medis.cart.decrease',$item['id']) }}" method="POST">
                        @csrf
                        <button class="qty-btn">-</button>
                    </form>

                    <span>{{ $item['qty'] }}</span>

                    <form action="{{ route('medis.cart.increase',$item['id']) }}" method="POST">
                        @csrf
                        <button class="qty-btn">+</button>
                    </form>
                </div>
            </div>

            <form action="{{ route('medis.cart.remove',$item['id']) }}" method="POST">
                @csrf
                <button class="btn-remove">🗑</button>
            </form>

        </div>

        @empty
            <p class="empty">Keranjang kosong</p>
        @endforelse

    </div>

    {{-- ================= SUMMARY + FORM ================= --}}
    <div class="summary">

        <h3>Form Peminjaman</h3>

        {{-- FORM INPUT --}}
        <div class="form-group">
            <label>Keperluan</label>
            <textarea name="keperluan" required placeholder="Contoh: Pemeriksaan pasien..."></textarea>
        </div>

        <div class="form-group">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" required>
        </div>

        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" required>
        </div>

        <hr style="margin:15px 0;">

        <h3>Ringkasan</h3>

        <p>Total Dipilih: <b id="totalItem">0</b></p>
        <p>Total Qty: <b id="totalQty">0</b></p>

        <button class="btn-checkout">
            ✔ Ajukan Peminjaman
        </button>

    </div>

</div>

</form>

{{-- ================= SCRIPT ================= --}}
<script>
const checkboxes = document.querySelectorAll('.check-item');
const totalItemEl = document.getElementById('totalItem');
const totalQtyEl = document.getElementById('totalQty');

checkboxes.forEach(cb => {
    cb.addEventListener('change', hitung);
});

function hitung(){
    let totalItem = 0;
    let totalQty = 0;

    checkboxes.forEach(cb => {
        if(cb.checked){
            totalItem++;

            let qty = cb.closest('.cart-item').querySelector('.qty-control span').innerText;
            totalQty += parseInt(qty);
        }
    });

    totalItemEl.innerText = totalItem;
    totalQtyEl.innerText = totalQty;
}
</script>

@endsection
