@extends('layouts.app')

@section('title','Menyetujui Peminjaman')

@section('content')

<style>

/* ================= ALERT ================= */
.alert{
    padding:12px 16px;
    border-radius:10px;
    margin-bottom:15px;
    font-size:14px;
    font-weight:500;
}

.alert-success{
    background:#ecfdf5;
    color:#10b981;
    border:1px solid #10b981;
}

.alert-danger{
    background:#fee2e2;
    color:#ef4444;
    border:1px solid #ef4444;
}

/* ================= TITLE ================= */
.page-title{
    margin-bottom:20px;
}

.page-title h2{
    font-size:26px;
    font-weight:700;
    color:#111827;
}

/* ================= TABLE ================= */
.table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 12px;
}

.table thead tr th{
    text-align:left;
    font-size:13px;
    font-weight:600;
    color:#6b7280;
    padding:12px 14px;
}

.table tbody tr{
    background:#fff;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
    border-radius:14px;
    transition:.25s;
}

.table tbody tr:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 25px rgba(59,75,255,0.12);
}

.table tbody tr td{
    padding:14px;
    font-size:14px;
    color:#374151;
    vertical-align:middle;
}

/* ================= STATUS ================= */
.status{
    padding:5px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:600;
    display:inline-block;
}

.status.menunggu{
    background:#fff7e6;
    color:#f59e0b;
}

.status.dipinjam{
    background:#ecfdf5;
    color:#10b981;
}

.status.tolak{
    background:#fee2e2;
    color:#ef4444;
}

/* ================= BUTTON ================= */
.btn{
    border:none;
    padding:8px 12px;
    border-radius:10px;
    font-size:13px;
    cursor:pointer;
    transition:.2s;
}

.btn-primary{
    background:#3b82f6;
    color:#fff;
}

.btn-primary:hover{
    background:#2563eb;
    transform:scale(1.05);
}

.btn-danger{
    background:#ef4444;
    color:#fff;
}

.btn-danger:hover{
    background:#dc2626;
    transform:scale(1.05);
}

td form{
    display:inline-block;
    margin-right:6px;
}

.empty{
    text-align:center;
    color:#9ca3af;
    padding:20px;
}

</style>

<!-- TITLE -->
<div class="page-title">
    <h2>Menyetujui Peminjaman</h2>
</div>

<!-- ALERT SUCCESS -->
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<!-- ALERT ERROR -->
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<table class="table">

<thead>
<tr>
    <th>No</th>
    <th>Nama Siswa</th>
    <th>Alat</th>
    <th>Jumlah</th>
    <th>Tanggal Pinjam</th>
    <th>Tanggal Kembali</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($peminjaman as $item)

<tr>

    <td>{{ $loop->iteration }}</td>

    <!-- USER -->
    <td>{{ optional($item->user)->name ?? '-' }}</td>

    <!-- ALAT -->
    <td>{{ optional($item->alat)->nama_alat ?? '-' }}</td>

    <!-- JUMLAH -->
    <td>{{ $item->jumlah ?? 0 }}</td>

    <!-- TANGGAL PINJAM -->
    <td>
        {{ $item->tanggal_pinjam
            ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y')
            : '-' }}
    </td>

    <!-- TANGGAL KEMBALI -->
    <td>
        {{ $item->tanggal_kembali
            ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y')
            : '-' }}
    </td>

    <!-- STATUS -->
    <td>
        <span class="status {{ $item->status }}">
            {{ ucfirst($item->status ?? '-') }}
        </span>
    </td>

    <!-- AKSI -->
    <td>

    @if($item->status == 'menunggu')

        <!-- SETUJUI -->
        <form action="{{ route('petugas.setujui',$item->id) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menyetujui peminjaman ini?')">
            @csrf
            <button class="btn btn-primary">Setujui</button>
        </form>

        <!-- TOLAK -->
        <form action="{{ route('petugas.tolak',$item->id) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menolak peminjaman ini?')">
            @csrf
            <button class="btn btn-danger">Tolak</button>
        </form>

    @else

        <span style="font-size:12px; color:#9ca3af;">-</span>

    @endif

    </td>

</tr>

@empty

<tr>
    <td colspan="8" class="empty">Tidak ada data peminjaman</td>
</tr>

@endforelse

</tbody>

</table>

@endsection
