@extends('layouts.app')

@section('title','Aktivitas Peminjaman')

@section('content')

<style>
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

.card{
    background:#fff;
    border-radius:16px;
    padding:18px;
    margin-bottom:15px;
    box-shadow:0 6px 18px rgba(0,0,0,0.05);
}

.status{
    display:inline-block;
    padding:5px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.status.menunggu{ background:#fef9c3; color:#ca8a04; }
.status.disetujui{ background:#dcfce7; color:#16a34a; }
.status.ditolak{ background:#fee2e2; color:#dc2626; }

.item{
    font-size:13px;
    margin-top:5px;
    color:#374151;
}
.empty{
    text-align:center;
    color:#9ca3af;
    padding:30px;
}
</style>

<div class="page-title">
    <h1>Riwayat Peminjaman</h1>
    <span>Semua aktivitas peminjaman kamu</span>
</div>

@forelse($peminjaman as $pinjam)

<div class="card">

    <b>Peminjaman #{{ $pinjam->id }}</b><br>

    <small>
        {{ $pinjam->tanggal_pinjam }} - {{ $pinjam->tanggal_kembali }}
    </small><br><br>

    Status:
    <span class="status {{ $pinjam->status }}">
        {{ ucfirst($pinjam->status) }}
    </span>

    <div style="margin-top:10px;">
        <b>Detail Alat:</b>

        @foreach($pinjam->detail as $d)
            <div class="item">
                - {{ $d->alat->nama_alat ?? '-' }} ({{ $d->qty }}x)
            </div>
        @endforeach
    </div>

</div>

@empty
    <div class="empty">Belum ada peminjaman</div>
@endforelse

@endsection
