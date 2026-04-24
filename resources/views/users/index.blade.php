@extends('layouts.app')

@section('title', 'Manajemen User - ALMEDIS')

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
        filter: brightness(1.1);
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

    /* ================= USER INFO ================= */
    .user-info strong {
        display: block;
        color: #1e293b;
        font-size: 15px;
        font-weight: 700;
    }

    .user-info small {
        color: #94a3b8;
        font-size: 13px;
    }

    /* ================= BADGE PRO (ROLE) ================= */
    .badge-pro {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
    }

    .dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .role-admin { background: #eef2ff; color: #4338ca; }
    .role-admin .dot { background: #4338ca; }

    .role-petugas { background: #fffbeb; color: #92400e; }
    .role-petugas .dot { background: #f59e0b; }

    .role-medis { background: #ecfdf5; color: #065f46; }
    .role-medis .dot { background: #10b981; }

    /* ================= STATUS ================= */
    .stat-active {
        color: #10b981;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .stat-inactive {
        color: #ef4444;
        font-weight: 800;
        display: flex;
        align-items: center;
        gap: 5px;
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
</style>

<div class="dashboard-container">
    <div class="page-header">
        <div>
            <h1>Manajemen User</h1>
            <p>Atur hak akses dan profil personil medis ALMEDIS</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn-add">
            <i class="fa-solid fa-user-plus"></i> Tambah User Baru
        </a>
    </div>

    <div class="card-table">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Identitas User</th>
                    <th>Hak Akses</th>
                    <th>Keterangan</th>
                    <th>Status Akun</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td><span style="color: #94a3b8; font-weight: 600;">{{ $loop->iteration }}</span></td>
                        <td>
                            <div class="user-info">
                                <strong>{{ $user->name }}</strong>
                                <small>{{ $user->email }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="badge-pro role-{{ strtolower($user->role) }}">
                                <div class="dot"></div>
                                {{ ucfirst($user->role) }}
                            </div>
                        </td>
                        <td>
                            <span style="color: #64748b; font-size: 13px;">{{ $user->keterangan ?? '-' }}</span>
                        </td>
                        <td>
                            @if(strtolower($user->status) == 'active' || strtolower($user->status) == 'aktif')
                                <span class="stat-active">● Aktif</span>
                            @else
                                <span class="stat-inactive">● Nonaktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-group" style="justify-content: center;">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-action btn-edit-user" title="Edit User">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete-user" onclick="return confirm('Hapus user ini?')" title="Hapus User">
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
                                <i class="fa-solid fa-users-slash"></i>
                                <p>Belum ada data user yang terdaftar dalam sistem.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
