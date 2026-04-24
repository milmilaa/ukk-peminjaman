@extends('layouts.app')

@section('title','Keranjang Peminjaman')

@section('content')

@php
    $cart = $cart ?? [];
@endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

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
}

/* ── ALERT ── */
.alert-success {
    background: #ecfdf5;
    color: #047857;
    padding: 14px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    border: 1.5px solid #bbf7d0;
    font-weight: 600;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

/* ── TITLE ── */
.page-title { margin-bottom: 30px; }
.page-title h1 {
    font-size: 28px;
    font-weight: 800;
    color: var(--text);
    letter-spacing: -0.5px;
}
.page-title span { font-size: 14px; color: var(--muted); }

/* ── LAYOUT ── */
.cart-container {
    display: grid;
    grid-template-columns: 1.5fr 1fr; /* Perbandingan diubah agar form lebih lebar */
    gap: 30px;
    align-items: start;
}

/* ── LIST ALAT ── */
.cart-list {
    background: var(--card);
    border-radius: 24px;
    padding: 24px;
    border: 1.5px solid var(--border);
    box-shadow: 0 10px 25px rgba(0,0,0,0.02);
}

.cart-item {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
    padding-bottom: 20px;
    border-bottom: 1.5px solid #f3f4f6;
    align-items: center;
}

.cart-item:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

.check-item {
    width: 20px;
    height: 20px;
    cursor: pointer;
    accent-color: var(--primary);
}

.cart-item img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 14px;
    border: 1px solid var(--border);
}

.cart-info { flex: 1; }
.cart-info h4 {
    font-size: 17px;
    font-weight: 700;
    color: var(--text);
    margin-bottom: 8px;
}

.qty-control {
    display: flex;
    align-items: center;
    gap: 12px;
}

.qty-btn {
    width: 32px;
    height: 32px;
    border: 1.5px solid var(--border);
    background: white;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
}
.qty-btn:hover { border-color: var(--primary); color: var(--primary); }

.btn-remove {
    background: #fee2e2;
    color: #dc2626;
    border: none;
    width: 38px;
    height: 38px;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.2s;
    font-size: 16px;
}
.btn-remove:hover { background: #fca5a5; color: white; }

/* ── SUMMARY + FORM (DI-GEDEIN) ── */
.summary {
    background: var(--card);
    border-radius: 24px;
    padding: 35px; /* Padding lebih besar */
    border: 1.5px solid var(--border);
    box-shadow: 0 15px 35px rgba(59, 75, 255, 0.05);
    position: sticky;
    top: 20px;
}

.summary h3 {
    font-size: 22px; /* Judul lebih besar */
    font-weight: 800;
    margin-bottom: 25px;
    color: var(--primary);
    display: flex;
    align-items: center;
    gap: 12px;
}

.form-group {
    margin-bottom: 22px;
}

.form-group label {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    display: block;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 15px 18px; /* Input lebih tebal/lega */
    border-radius: 14px;
    border: 1.5px solid var(--border);
    font-size: 15px; /* Teks input lebih besar */
    background-color: #fcfdfe;
    font-family: inherit;
    transition: all 0.3s ease;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary);
    background-color: #fff;
    box-shadow: 0 0 0 5px rgba(59, 75, 255, 0.1);
}

.summary-details {
    background: #f0f3ff; /* Warna bg ringkasan lebih kontras */
    padding: 20px;
    border-radius: 18px;
    margin: 25px 0;
    border: 1px dashed #c7d2fe;
}

.summary-details p {
    display: flex;
    justify-content: space-between;
    font-size: 15px;
    margin-bottom: 10px;
    color: var(--muted);
}

.summary-details p b {
    color: var(--primary);
    font-size: 18px;
}

.btn-checkout {
    width: 100%;
    background: linear-gradient(135deg, var(--primary), var(--primary-2));
    color: white;
    padding: 18px; /* Tombol lebih tinggi */
    border-radius: 16px;
    border: none;
    font-weight: 700;
    font-size: 17px;
    cursor: pointer;
    transition: 0.3s;
    box-shadow: 0 8px 15px rgba(59, 75, 255, 0.25);
}

.btn-checkout:hover {
    transform: translateY(-2px);
    filter: brightness(1.1);
    box-shadow: 0 12px 20px rgba(59, 75, 255, 0.35);
}

.empty { text-align: center; color: var(--muted); padding: 40px 0; }
</style>

{{-- ✅ ALERT SUKSES --}}
@if(session('success'))
<div class="alert-success" id="alertBox">
    <span>✔ {{ session('success') }}</span>
</div>
@endif

<div class="page-title">
    <h1>Keranjang Saya</h1>
    <span>Kelola daftar alat dan lengkapi data peminjaman</span>
</div>

<form action="{{ route('medis.peminjaman.store') }}" method="POST">
@csrf

<div class="cart-container">

    {{-- ================= LIST ALAT ================= --}}
    <div class="cart-list">
        @forelse($cart as $item)
        @php
            $image = (!empty($item['gambar']) && file_exists(public_path('storage/'.$item['gambar'])))
                ? asset('storage/'.$item['gambar'])
                : asset('images/no-image.png');
        @endphp

        <div class="cart-item">
            <input type="checkbox" name="selected_items[]" value="{{ $item['id'] }}" class="check-item">

            <img src="{{ $image }}" onerror="this.src='{{ asset('images/no-image.png') }}'">

            <div class="cart-info">
                <h4>{{ $item['nama_alat'] }}</h4>
                <div class="qty-control">
                    <button type="submit" formaction="{{ route('medis.cart.decrease',$item['id']) }}" class="qty-btn">-</button>
                    <span>{{ $item['qty'] }}</span>
                    <button type="submit" formaction="{{ route('medis.cart.increase',$item['id']) }}" class="qty-btn">+</button>
                </div>
            </div>

            <button type="submit" formaction="{{ route('medis.cart.remove',$item['id']) }}" class="btn-remove">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </div>

        @empty
            <div class="empty">
                <p>Keranjang Anda masih kosong.</p>
            </div>
        @endforelse
    </div>

    {{-- ================= FORM PEMINJAMAN (UPGRADED) ================= --}}
    <div class="summary">
        <h3><i class="fa-solid fa-file-signature"></i> Form Peminjaman</h3>

        <div class="form-group">
            <label>Keperluan Peminjaman</label>
            <textarea name="keperluan" rows="4" required placeholder="Jelaskan secara detail alasan peminjaman..."></textarea>
        </div>

        <div class="form-group">
            <label>Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" required>
        </div>

        <div class="form-group">
            <label>Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" required>
        </div>

        <div class="summary-details">
            <p>Total Jenis Alat: <b id="totalItem">0</b></p>
            <p>Total Jumlah (Qty): <b id="totalQty">0</b></p>
        </div>

        <button type="submit" class="btn-checkout">
            ✔ Ajukan Peminjaman Sekarang
        </button>
    </div>
</div>
</form>

<script>
// Logic hitung total otomatis saat checkbox di-check
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

// Alert auto hide
setTimeout(() => {
    let alert = document.getElementById('alertBox');
    if(alert) {
        alert.style.transition = '0.5s';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    }
}, 3000);
</script>

@endsection
