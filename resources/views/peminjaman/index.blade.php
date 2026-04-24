@extends('layouts.app')

@section('title', 'Data Peminjaman - ALMEDIS')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    :root {
        --primary: #2563eb;
        --primary-hover: #1d4ed8;
        --bg-main: #f8fafc;
        --text-dark: #0f172a;
        --text-slate: #64748b;
        --white: #ffffff;
        --border: #e2e8f0;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
        --shadow-md: 0 10px 25px -5px rgba(0,0,0,0.05);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: var(--bg-main);
        color: var(--text-dark);
    }

    .dashboard-container {
        padding: 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ================= HEADER ================= */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .page-header h1 {
        font-size: 32px;
        font-weight: 800;
        color: var(--text-dark);
        margin: 0;
        letter-spacing: -1px;
    }

    .page-header p {
        color: var(--text-slate);
        font-size: 15px;
        margin-top: 6px;
    }

    .header-actions {
        display: flex;
        gap: 14px;
    }

    .btn-custom {
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none !important;
        border: none;
    }

    .btn-add {
        background: var(--primary);
        color: var(--white) !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
    }

    .btn-add:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(37, 99, 235, 0.35);
    }

    .btn-export {
        background: var(--white);
        color: var(--text-dark) !important;
        border: 1px solid var(--border);
    }

    .btn-export:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    /* ================= CARD & TABLE ================= */
    .card-table {
        background: var(--white);
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background: #f8fafc;
    }

    .table th {
        text-align: left;
        padding: 18px 24px;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-slate);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid var(--border);
    }

    .table td {
        padding: 20px 24px;
        vertical-align: middle;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: #fcfdfe;
    }

    /* ================= BADGE STATUS ================= */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-dipinjam {
        background: #fef9c3;
        color: #854d0e;
    }

    .status-dikembalikan {
        background: #dcfce7;
        color: #166534;
    }

    /* ================= ACTION BUTTONS ================= */
    .action-group {
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        transition: all 0.2s ease;
        background: #f1f5f9;
        color: #475569;
        border: none;
        cursor: pointer;
    }

    .btn-action:hover {
        transform: scale(1.1);
    }

    .btn-edit:hover {
        background: #dbeafe;
        color: #2563eb;
    }

    .btn-delete:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    /* ================= EMPTY STATE ================= */
    .empty-state {
        text-align: center;
        padding: 80px 24px;
    }

    .empty-state i {
        font-size: 56px;
        color: #e2e8f0;
        margin-bottom: 20px;
    }

    .empty-state p {
        color: var(--text-slate);
        font-weight: 500;
    }
</style>

<div class="dashboard-container">
    <div class="page-header">
        <div>
            <h1>Data Peminjaman</h1>
            <p>Kelola sirkulasi peminjaman alat medis ALMEDIS secara real-time</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('petugas.peminjaman.export.excel') }}" class="btn-custom btn-export">
                <i class="fa-solid fa-file-excel"></i> Export Excel
            </a>
            <a href="{{ route('admin.peminjaman.create') }}" class="btn-custom btn-add">
                <i class="fa-solid fa-plus"></i> Tambah Pinjaman
            </a>
        </div>
    </div>

    <div class="card-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th>Peminjam</th>
                        <th>Alat Medis</th>
                        <th style="text-align: center;">Qty</th>
                        <th>Status</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjamans as $key => $item)
                        <tr>
                            <td style="text-align: center;">
                                <span style="color: var(--text-slate); font-weight: 600;">{{ $key + 1 }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--text-dark);">{{ $item->user->name ?? '-' }}</div>
                                <div style="font-size: 12px; color: var(--text-slate);">{{ $item->user->role ?? '' }}</div>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--text-dark);">{{ $item->alat->nama_alat ?? '-' }}</div>
                            </td>
                            <td style="text-align: center;">
                                <span style="font-weight: 700; background: #f1f5f9; padding: 4px 10px; border-radius: 6px;">{{ $item->stok }}</span>
                            </td>
                            <td>
                                @php $status = strtolower($item->status); @endphp
                                <span class="badge-status status-{{ $status }}">
                                    <i class="fa-solid {{ $status == 'dipinjam' ? 'fa-clock' : 'fa-check-circle' }}"></i>
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                <span style="color: var(--text-slate); font-weight: 500;">
                                    <i class="fa-regular fa-calendar-minus" style="margin-right: 5px; opacity: 0.7;"></i>
                                    {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-' }}
                                </span>
                            </td>
                            <td>
                                <span style="color: var(--text-slate); font-weight: 500;">
                                    <i class="fa-regular fa-calendar-check" style="margin-right: 5px; opacity: 0.7;"></i>
                                    {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.peminjaman.edit', $item->id) }}" class="btn-action btn-edit" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('admin.peminjaman.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('Yakin hapus data ini?')" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fa-solid fa-folder-open"></i>
                                    <p>Belum ada data peminjaman yang tercatat dalam database.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
