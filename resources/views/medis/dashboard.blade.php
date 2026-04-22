@extends('layouts.app')

@section('title','Dashboard Medis')

@section('content')

@php
    $alat = $alat ?? collect();
    $peminjaman = $peminjaman ?? collect();
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

/* ================= ALERT ================= */
.alert{
    display:flex;
    align-items:center;
    gap:10px;
    padding:14px 16px;
    border-radius:12px;
    margin-bottom:18px;
    font-size:14px;
    font-weight:500;
    animation:fadeSlide 0.4s ease;
}
@keyframes fadeSlide{
    from{opacity:0; transform:translateY(-10px);}
    to{opacity:1; transform:translateY(0);}
}
.alert.success{
    background:#ecfdf5;
    color:#047857;
    border:1px solid #bbf7d0;
}
.alert.error{
    background:#fef2f2;
    color:#b91c1c;
    border:1px solid #fecaca;
}

/* ================= TITLE ================= */
.page-title{
    margin-bottom:20px;
}
.page-title h1{
    font-size:26px;
    font-weight:700;
    color:#111827;
}
.page-title span{
    font-size:14px;
    color:#6b7280;
}

/* ================= GRID ================= */
.product-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(210px,1fr));
    gap:20px;
}

/* ================= CARD ================= */
.product-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
    transition:0.25s ease;
}
.product-card:hover{
    transform:translateY(-6px);
    box-shadow:0 12px 28px rgba(0,0,0,0.10);
}

.product-img{
    width:100%;
    height:180px;
    object-fit:cover;
    background:#e5e7eb;
}

.product-body{
    padding:14px;
}

.product-name{
    font-size:15px;
    font-weight:700;
    margin-bottom:6px;
}

.stock{
    font-size:12px;
    color:#6b7280;
}

.status{
    display:inline-block;
    font-size:11px;
    padding:4px 10px;
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

.cart-btn{
    margin-top:12px;
    width:100%;
    padding:10px;
    border:none;
    border-radius:12px;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
    background:linear-gradient(135deg,#3b4bff,#5f6fff);
    color:#fff;
}
.cart-btn:disabled{
    background:#cbd5e1;
}

/* ================= RIWAYAT ================= */
.riwayat{
    margin-top:35px;
    background:#fff;
    padding:20px;
    border-radius:16px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.riwayat h3{
    margin-bottom:15px;
}

.riwayat-item{
    padding:12px;
    border-bottom:1px solid #eee;
    font-size:14px;
}

.badge-status{
    padding:4px 8px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
}

.badge-menunggu{
    background:#fef9c3;
    color:#92400e;
}
.badge-disetujui{
    background:#dcfce7;
    color:#166534;
}
.badge-ditolak{
    background:#fee2e2;
    color:#991b1b;
}

</style>

<!-- ================= TITLE ================= -->
<div class="page-title">
    <h1>Daftar Alat Medis</h1>
    <span>Pilih alat dan masukkan ke keranjang</span>
</div>

<!-- ================= GRID ================= -->
<div class="product-grid">

@forelse($alat as $item)

@php
    $stok = $item->jumlah ?? 0;
    $image = (!empty($item->gambar) && file_exists(public_path('storage/'.$item->gambar)))
        ? asset('storage/'.$item->gambar)
        : asset('images/no-image.png');
@endphp

<div class="product-card">
    <img src="{{ $image }}" class="product-img">

    <div class="product-body">
        <div class="product-name">{{ $item->nama_alat }}</div>

        <div class="stock">Stok: {{ $stok }}</div>

        @if($stok > 0)
            <span class="status available">Tersedia</span>
        @else
            <span class="status empty">Habis</span>
        @endif

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

<!-- ================= RIWAYAT ================= -->
<div class="riwayat">
    <h3>📋 Riwayat Aktivitas</h3>

    @forelse($peminjaman as $item)

        <div class="riwayat-item">

            <b>Peminjaman #{{ $item->id }}</b><br>

            📅 {{ $item->tanggal_pinjam }} - {{ $item->tanggal_kembali }} <br>

            📌 {{ $item->keperluan ?? '-' }} <br>

            <!-- STATUS -->
            Status:
            @if($item->status == 'menunggu')
                <span class="badge-status badge-menunggu">Menunggu</span>
            @elseif($item->status == 'disetujui')
                <span class="badge-status badge-disetujui">Disetujui</span>
            @else
                <span class="badge-status badge-ditolak">Ditolak</span>
            @endif

            <!-- 🔥 DETAIL ALAT -->
            <div style="margin-top:8px;">
                <small><b>Alat:</b></small><br>

                @foreach($item->detail as $d)
                    - {{ $d->alat->nama_alat }} ({{ $d->qty }}) <br>
                @endforeach
            </div>

        </div>

    @empty
        <p style="color:#6b7280;">Belum ada aktivitas</p>
    @endforelse

</div>

{{-- ================= AUTO HIDE ALERT ================= --}}
<script>
setTimeout(() => {
    let alert = document.getElementById('alertBox');
    if(alert){
        alert.style.opacity = "0";
        setTimeout(()=> alert.remove(), 400);
    }
}, 3000);
</script>

@endsection
