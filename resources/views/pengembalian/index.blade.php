@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-header h1 {
        font-size: 26px;
        font-weight: 600;
        color: #1f2937;
    }

    .btn-add {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
    }

    .card {
        background: #fff;
        border-radius: 14px;
        padding: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,.06);
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
    }

    table th {
        background: #eef2ff;
        text-align: left;
    }
</style>

<div class="page-header">
    <h1>Data Pengembalian</h1>

    {{-- FIX ROUTE ADMIN PREFIX --}}
    <a href="{{ route('admin.pengembalian.create') }}" class="btn-add">
        + Tambah Pengembalian
    </a>
</div>

<div class="card">

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:10px 14px;border-radius:8px;margin-bottom:15px">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Alat</th>
                <th>Jumlah</th>
                <th>Tgl Kembali</th>
                <th>Kondisi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($pengembalians as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    {{-- SAFE ACCESS BIAR TIDAK ERROR --}}
                    <td>{{ $item->peminjaman->user->name ?? '-' }}</td>
                    <td>{{ $item->peminjaman->alat->nama_alat ?? '-' }}</td>
                    <td>{{ $item->peminjaman->jumlah ?? '-' }}</td>

                    <td>
                        {{ $item->tanggal_kembali
                            ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y')
                            : '-' }}
                    </td>

                    <td>{{ $item->kondisi ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center;color:#6b7280">
                        Data pengembalian belum ada
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
