@extends('layouts.app')

@section('title', 'Data Peminjaman')

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
        font-size: 14px;
        text-decoration: none;
        transition: .3s;
    }

    .btn-add:hover {
        box-shadow: 0 8px 20px rgba(37,99,235,.35);
        transform: translateY(-2px);
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

    table thead {
        background: #eef2ff;
    }

    table th, table td {
        padding: 14px;
        text-align: left;
        font-size: 14px;
        border-bottom: 1px solid #e5e7eb;
    }

    table th {
        font-weight: 600;
        color: #1f2937;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-dipinjam {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-dikembalikan {
        background: #dcfce7;
        color: #166534;
    }
</style>

<div class="page-header">
    <h1>Data Peminjaman</h1>
    <a href="{{ route('peminjaman.create') }}" class="btn-add">
        <i class="fa-solid fa-plus"></i> Tambah Peminjaman
    </a>
</div>

<div class="card">

    @if(session('success'))
        <div style="margin-bottom:15px;color:#166534;background:#dcfce7;padding:10px 14px;border-radius:8px">
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
                <th>Tanggal Pinjam</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->alat->nama }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->tanggal_pinjam }}</td>
                <td>
                    @if($item->status === 'dipinjam')
                        <span class="badge badge-dipinjam">Dipinjam</span>
                    @else
                        <span class="badge badge-dikembalikan">Dikembalikan</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align:center;color:#6b7280">
                    Data peminjaman belum ada
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
