@extends('layouts.app')

@section('title', 'Cetak Peminjaman')

@section('content')

<style>
.page-title {
    margin-bottom: 20px;
}

.page-title h1 {
    font-size: 26px;
    font-weight: 700;
}

.card-box {
    background: #fff;
    padding: 20px;
    border-radius: 16px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.06);
}

/* TABLE */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

.table th, .table td {
    padding: 12px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

.table th {
    background: #f9fafb;
    text-align: left;
}

/* BUTTON PRINT */
.print-btn {
    margin-bottom: 15px;
}

/* PRINT STYLE */
@media print {
    .print-btn, .sidebar, nav {
        display: none !important;
    }

    body {
        background: white;
    }

    .card-box {
        box-shadow: none;
        border: none;
    }
}
</style>

<div class="page-title">
    <h1>📄 Cetak Laporan Peminjaman</h1>
    <span>Data peminjaman alat terbaru</span>
</div>

<div class="card-box">

    <button onclick="window.print()" class="btn btn-primary print-btn">
        🖨️ Print Laporan
    </button>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>

        <tbody>
            @forelse($peminjaman as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td>{{ $item->alat->nama_alat ?? '-' }}</td>
                <td>{{ $item->jumlah ?? 1 }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ $item->created_at->format('d-m-Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
