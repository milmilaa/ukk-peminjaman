@extends('layouts.app')

@section('title', 'Data Kategori - ALMEDIS')

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
        max-width: 850px; /* Dikecilkan lagi karena kolomnya sedikit */
        margin: 0 auto;
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
        color: #fff !important;
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
        background: #f8fafc;
        border-bottom: 2px solid #f1f5f9;
    }

    .table th {
        text-align: center; /* Paksa header ke tengah */
        padding: 20px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: 20px;
        vertical-align: middle;
        font-size: 15px;
        color: #1e293b;
        border-bottom: 1px solid #f1f5f9;
        text-align: center; /* Paksa isi cell ke tengah */
    }

    .table tbody tr:hover {
        background-color: #fbfdff;
    }

    /* ================= ACTION BUTTONS ================= */
    .action-group {
        display: flex;
        gap: 8px;
        justify-content: center; /* Center tombol aksi */
    }

    .btn-action {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-edit-user {
        background: #f0f9ff;
        color: #0369a1;
    }

    .btn-edit-user:hover {
        background: #0369a1;
        color: #ffffff;
    }

    .btn-delete-user {
        background: #fff1f2;
        color: #be123c;
    }

    .btn-delete-user:hover {
        background: #be123c;
        color: #ffffff;
    }

    .alert-success {
        background: #dcfce7;
        color: #15803d;
        padding: 12px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-weight: 700;
        border-left: 5px solid #22c55e;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }
</style>

<div class="dashboard-container">
    <div class="page-header">
        <div>
            <h1>Data Kategori</h1>
            <p>Data kategori alat medis ALMEDIS</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card-table">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 80px;">No</th>
                    <th>Nama Kategori</th>
                    <th style="width: 180px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kategoris as $item)
                    <tr>
                        <td style="font-weight: 700; color: #94a3b8;">{{ $loop->iteration }}</td>
                        <td>
                            <div style="font-weight: 700; color: #1e293b;">
                                {{ $item->nama }}
                            </div>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn-action btn-edit-user" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete-user" onclick="return confirm('Yakin hapus kategori ini?')" title="Hapus">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <i class="fa-solid fa-folder-open" style="font-size: 40px; margin-bottom: 10px; display: block;"></i>
                                <p>Belum ada data kategori.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
