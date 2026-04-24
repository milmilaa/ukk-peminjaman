@extends('layouts.app')

@section('title', 'Data Alat - ALMED')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f4f7fa;
    }

    .dashboard-container {
        padding: 40px;
    }

    /* ================= HEADER ================= */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-header h1 {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -1px;
    }

    .page-header p {
        color: #64748b;
        font-size: 14px;
        margin-top: 4px;
    }

    .btn-add {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: #fff;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
        box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 20px -5px rgba(37, 99, 235, 0.4);
        color: white;
    }

    /* ================= CARD & TABLE ================= */
    .card-table {
        background: #ffffff;
        border-radius: 20px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .table thead {
        background: #f8fafc; /* Header abu-abu sangat muda biar clean */
        border-bottom: 2px solid #f1f5f9;
    }

    .table th {
        text-align: left;
        padding: 20px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: 18px 20px;
        vertical-align: middle;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:hover {
        background-color: #fbfdff;
    }

    /* ================= ALAT IMAGE ================= */
    .alat-img-wrapper {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
    }

    .alat-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* ================= STOK BADGE ================= */
    .stok-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    .stok-ready {
        background: #dcfce7;
        color: #15803d;
    }

    .stok-limit {
        background: #fef3c7;
        color: #b45309;
    }

    .stok-empty {
        background: #fef2f2;
        color: #b91c1c;
    }

    /* ================= ACTION BUTTONS ================= */
    .action-group {
        display: flex;
        gap: 8px;
    }

    .btn-action {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-edit-alat {
        background: #f0f9ff;
        color: #0369a1;
    }

    .btn-edit-alat:hover {
        background: #0369a1;
        color: #ffffff;
    }

    .btn-delete-alat {
        background: #fff1f2;
        color: #be123c;
    }

    .btn-delete-alat:hover {
        background: #be123c;
        color: #ffffff;
    }

    /* ================= EMPTY STATE ================= */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    .empty-state p {
        color: #64748b;
        font-size: 15px;
    }
</style>

<div class="dashboard-container">
    <div class="page-header">
        <div>
            <h1>Data Alat</h1>
            <p>Manajemen stok dan inventaris alat kesehatan ALMED</p>
        </div>
        <a href="{{ route('admin.alat.create') }}" class="btn-add">
            <i class="fa-solid fa-plus-circle"></i> Tambah Alat Baru
        </a>
    </div>

    <div class="card-table">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Gambar</th>
                    <th>Nama Alat</th>
                    <th>Stok</th>
                    <th>Harga Barang</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($alat as $item)
                    <tr>
                        <td><span style="color: #94a3b8; font-weight: 600;">{{ $loop->iteration }}</span></td>

                        <td>
                            <div class="alat-img-wrapper">
                                @if($item->gambar && file_exists(public_path('storage/'.$item->gambar)))
                                    <img src="{{ asset('storage/' . $item->gambar) }}" class="alat-img">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" class="alat-img" style="opacity: 0.5;">
                                @endif
                            </div>
                        </td>

                        <td>
                            <div style="font-weight: 700; color: #1e293b;">{{ $item->nama_alat }}</div>
                            <div style="font-size: 12px; color: #94a3b8;">ID: ALM-{{ 1000 + $item->id }}</div>
                        </td>

                        <td>
                            @php
                                $stokClass = $item->stok > 10 ? 'stok-ready' : ($item->stok > 0 ? 'stok-limit' : 'stok-empty');
                            @endphp
                            <span class="stok-badge {{ $stokClass }}">
                                {{ $item->stok }} Unit
                            </span>
                        </td>

                        <td>
                            <span style="font-weight: 600; color: #059669;">
                                Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        <td>
                            <div class="action-group" style="justify-content: center;">
                                <a href="{{ route('admin.alat.edit', $item->id) }}" class="btn-action btn-edit-alat" title="Edit Alat">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('admin.alat.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn-action btn-delete-alat"
                                            onclick="return confirm('Yakin hapus alat ini?')"
                                            title="Hapus Alat">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="fa-solid fa-box-open"></i>
                                <p>Belum ada data alat kesehatan yang terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
