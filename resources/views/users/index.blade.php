@extends('layouts.app')

@section('title', 'Data User')

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
    }

    .table thead {
        background: #4f46e5;
    }

    /* ✅ CENTER SEMUA */
    .table th,
    .table td {
        text-align: center;
        padding: 14px;
        font-size: 14px;
    }

    .table th {
        color: #ffffff;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        border-bottom: 1px solid #e5e7eb;
        color: #374151;
    }

    .table tbody tr:hover {
        background: #f1f5ff;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        text-transform: capitalize;
        display: inline-block;
    }

    .badge.admin {
        background: #e0e7ff;
        color: #1e3a8a;
    }

    .badge.petugas {
        background: #fef9c3;
        color: #854d0e;
    }

    .badge.medis {
        background: #dcfce7;
        color: #166534;
    }

    .badge.active {
        background: #dcfce7;
        color: #166534;
    }

    .badge.inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    /* ✅ AKSI DI TENGAH */
    .action {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .btn {
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 13px;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #facc15;
        color: #854d0e;
    }

    .btn-delete {
        background: #fee2e2;
        color: #991b1b;
    }

    .empty {
        text-align: center;
        padding: 40px;
        color: #6b7280;
    }
</style>

<div class="page-header">
    <div>
        <h1>Data User</h1>
        <span>Daftar pengguna yang terdaftar dalam sistem</span>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-add">
        <i class="fa-solid fa-user-plus"></i> Tambah User
    </a>
</div>

<div class="card">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td>
                        <span class="badge {{ $user->role }}">
                            {{ $user->role }}
                        </span>
                    </td>

                    <td>
                        @if($user->role == 'admin')
                            IT / Pengelola Sistem
                        @elseif($user->role == 'petugas')
                            Gudang Alat
                        @elseif($user->role == 'medis')
                            Tenaga Medis
                        @endif
                    </td>

                    <td>
                        <span class="badge {{ $user->status }}">
                            {{ $user->status }}
                        </span>
                    </td>

                    <td>
                        <div class="action">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-delete"
                                    onclick="return confirm('Yakin hapus user ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="empty">
                            <i class="fa-solid fa-users-slash fa-2x"></i>
                            <p>Data user belum tersedia</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
