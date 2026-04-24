@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Global Reset & Google Font */
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
        color: #1e293b;
    }

    .dashboard-container {
        padding: 30px 40px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ================= HEADER ================= */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 35px;
    }

    .header-title h1 {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .header-title p {
        font-size: 14px;
        color: #64748b;
        margin-top: 4px;
        font-weight: 500;
    }

    /* ================= BUTTON ADD ================= */
    .btn-add {
        background: #3b4bff;
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(59, 75, 255, 0.25);
    }

    .btn-add:hover {
        background: #2f3de6;
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(59, 75, 255, 0.35);
        color: #fff;
    }

    /* ================= CARD & TABLE ================= */
    .card-box {
        background: #ffffff;
        border-radius: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.02);
        padding: 20px;
        overflow: hidden;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .table th {
        background-color: #fcfdff;
        padding: 18px 20px;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
        font-size: 14px;
    }

    .table tr:last-child td {
        border-bottom: none;
    }

    .table tr:hover td {
        background-color: #f8faff;
    }

    /* ================= BADGES & STYLES ================= */
    .badge {
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        letter-spacing: 0.3px;
    }

    .badge-success { background: #ecfdf5; color: #10b981; border: 1px solid #d1fae5; }
    .badge-danger { background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }
    .badge-warning { background: #fffbeb; color: #f59e0b; border: 1px solid #fef3c7; }

    .qty-badge {
        background: #f1f5f9;
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 800;
        color: #475569;
        font-size: 12px;
    }

    .trans-id {
        display: block;
        font-size: 11px;
        color: #94a3b8;
        font-weight: 700;
        margin-top: 2px;
    }

    /* ================= FOOTER KETERANGAN ================= */
    .table-footer-info {
        margin-top: 20px;
        padding: 20px;
        background: #fcfdff;
        border-radius: 18px;
        border: 1px solid #f1f5f9;
    }

    .info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .legend-group {
        display: flex;
        gap: 8px;
    }

    .note-box {
        background-color: #ffffff;
        padding: 15px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #e2e8f0;
    }

    .note-box i {
        color: #3b4bff;
        font-size: 18px;
    }

    .note-text {
        font-size: 13px;
        color: #64748b;
        margin: 0;
        line-height: 1.5;
    }

    /* Alert Styling */
    .custom-alert {
        background: #dcfce7;
        color: #166534;
        padding: 16px;
        border-radius: 12px;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        border: 1px solid #bbf7d0;
        animation: slideIn 0.4s ease-out;
    }

    @keyframes slideIn {
        from { transform: translateY(-10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>

<div class="dashboard-container">
    <div class="page-header">
        <div class="header-title">
            <h1>Data Pengembalian</h1>
            <p>Kelola sirkulasi pengembalian alat medis ALMEDIS</p>
        </div>

        <a href="{{ route('admin.pengembalian.create') }}" class="btn-add">
            <i class="fa-solid fa-plus"></i> Tambah Pengembalian
        </a>
    </div>

    @if(session('success'))
        <div class="custom-alert">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card-box">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Peminjam</th>
                        <th>Alat Medis</th>
                        <th width="120">Stok/Qty</th>
                        <th>Tgl Kembali</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $item)
                        <tr>
                            <td><span style="color: #cbd5e1; font-weight: 800;">{{ $loop->iteration }}</span></td>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">{{ $item->peminjaman->user->name ?? '-' }}</div>
                                <span class="trans-id">TRANS-ID: #{{ $item->id }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #334155;">{{ $item->peminjaman->alat->nama_alat ?? '-' }}</div>
                            </td>
                            <td>
                                <span class="qty-badge">
                                    {{ $item->peminjaman->stok ?? '0' }} Unit
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #475569;">
                                    <i class="fa-regular fa-calendar-days" style="margin-right: 6px; color: #3b4bff; opacity: 0.7;"></i>
                                    {{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}
                                </div>
                            </td>
                            <td>
                                @php
                                    $kondisi = strtolower($item->kondisi ?? '');
                                    $badgeClass = 'badge-warning';
                                    if($kondisi == 'baik') $badgeClass = 'badge-success';
                                    elseif($kondisi == 'rusak') $badgeClass = 'badge-danger';
                                @endphp
                                <span class="badge {{ $badgeClass }}">
                                    <i class="fa-solid fa-circle" style="font-size: 6px;"></i>
                                    {{ strtoupper($item->kondisi ?? 'N/A') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding: 80px; color:#94a3b8;">
                                <i class="fa-solid fa-folder-open fa-3x" style="display: block; margin-bottom: 15px; opacity: 0.1;"></i>
                                <span style="font-weight: 500;">Belum ada data pengembalian yang tercatat.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer-info">
            <div class="info-header">
                <div style="font-size: 13px; font-weight: 800; color: #94a3b8; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-chart-simple" style="color: #3b4bff; margin-right: 8px;"></i>
                    RINGKASAN: <span style="color: #334155; margin-left: 5px;">{{ $pengembalians->count() }} Entri Tercatat</span>
                </div>

                <div class="legend-group">
                    <span class="badge badge-success">BAIK</span>
                    <span class="badge badge-danger">RUSAK</span>
                </div>
            </div>

            <div class="note-box">
                <i class="fa-solid fa-circle-info"></i>
                <div class="note-text">
                    <strong>Pusat Informasi:</strong> Data ini memantau kelayakan alat medis secara berkala. Pastikan alat dengan kondisi <strong>RUSAK</strong> segera ditindaklanjuti untuk menjaga kualitas layanan kesehatan.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
