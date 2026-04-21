@extends('layouts.app')

@section('title', 'Data Kategori')

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

    .page-header span {
        color: #6b7280;
        font-size: 14px;
    }

    .btn-add {
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        color: #fff;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(37,99,235,.35);
    }

    .card {
        background: #fff;
        border-radius: 14px;
        padding: 22px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.06);
        animation: fadeUp 0.6s ease;
    }

    @keyframes fadeUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        overflow: hidden;
        border-radius: 10px;
    }

    /* ✅ HEADER CENTER */
    .table thead {
        background: #4f46e5;
    }

    .table thead th {
        text-align: center;
        padding: 14px;
        font-size: 13px;
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ✅ ISI JUGA CENTER */
    .table td {
        text-align: center;
        padding: 14px;
        border-bottom: 1px solid #e5e7eb;
        font-size: 14px;
        color: #374151;
    }

    .table tbody tr:hover {
        background: #f1f5ff;
        transition: 0.2s;
    }

    .nama-kategori {
        font-weight: 500;
        color: #111827;
    }

    .action {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .btn {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        transition: 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #facc15;
        color: #854d0e;
    }

    .btn-edit:hover {
        background: #fde047;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-delete:hover {
        background: #fecaca;
    }

    .empty {
        text-align: center;
        padding: 40px;
        color: #6b7280;
    }
</style>

<div class="page-header">
    <div>
        <h1>Data Kategori</h1>
        <span>Daftar kategori alat peminjaman</span>
    </div>

    <a href="{{ route('admin.kategori.create') }}" class="btn-add">
        <i class="fa-solid fa-plus"></i> Tambah Kategori
    </a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th style="width: 60px;">No</th>
                <th>Nama Kategori</th>
                <th style="width: 120px;">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($kategoris as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        <span class="nama-kategori">
                            {{ $item->nama }}
                        </span>
                    </td>

                    <td>
                        <div class="action">
                            <a href="{{ route('admin.kategori.edit', $item->id) }}" class="btn btn-edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('admin.kategori.destroy', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete"
                                    onclick="return confirm('Yakin hapus kategori ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">
                        <div class="empty">
                            <i class="fa-solid fa-tags fa-2x"></i>
                            <p>Data kategori belum tersedia</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
