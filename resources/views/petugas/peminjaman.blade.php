@extends('layouts.app')

@section('title','Menyetujui Peminjaman')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }

    .container-fluid {
        padding: 30px;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* ================= HEADER SECTION ================= */
    .page-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 35px;
    }

    .header-icon {
        width: 54px;
        height: 54px;
        background: #3b4bff;
        color: white;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        box-shadow: 0 8px 20px rgba(59, 75, 255, 0.25);
    }

    .header-text h2 {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
        letter-spacing: -0.5px;
    }

    .header-text p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
        font-weight: 500;
    }

    /* ================= ALERT ================= */
    .alert {
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        border: none;
        animation: slideIn 0.4s ease-out;
    }
    .alert-success { background: #ecfdf5; color: #10b981; border-left: 5px solid #10b981; }
    .alert-danger { background: #fef2f2; color: #ef4444; border-left: 5px solid #ef4444; }

    @keyframes slideIn {
        from { transform: translateY(-10px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* ================= TABLE CARD ================= */
    .table-container {
        background: #ffffff;
        border-radius: 24px;
        padding: 20px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.02);
        border: 1px solid #e2e8f0;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .table thead th {
        background: #fcfdff;
        padding: 18px 20px;
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid #f1f5f9;
    }

    .table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 14px;
    }

    .table tbody tr:last-child td { border-bottom: none; }

    .table tbody tr:hover td {
        background-color: #fcfdff;
    }

    /* ================= ALAT ITEM ================= */
    .alat-wrapper {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .alat-item {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8fafc;
        padding: 8px 12px;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }

    .alat-img {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        object-fit: cover;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .alat-info b {
        font-size: 13px;
        color: #1e293b;
        display: block;
    }

    .alat-info small {
        color: #64748b;
        font-weight: 700;
    }

    /* ================= STATUS BADGE ================= */
    .status {
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-transform: uppercase;
    }
    .status.menunggu { background: #fffbeb; color: #f59e0b; border: 1px solid #fef3c7; }
    .status.dipinjam { background: #ecfdf5; color: #10b981; border: 1px solid #d1fae5; }
    .status.ditolak { background: #fef2f2; color: #ef4444; border: 1px solid #fee2e2; }

    /* ================= BUTTONS ================= */
    .btn-group {
        display: flex;
        gap: 8px;
    }

    .btn {
        padding: 10px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-primary {
        background: #3b4bff;
        color: white;
        box-shadow: 0 4px 12px rgba(59, 75, 255, 0.2);
    }
    .btn-primary:hover {
        background: #2f3de6;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(59, 75, 255, 0.3);
    }

    .btn-danger {
        background: #fff1f2;
        color: #ef4444;
        border: 1px solid #fee2e2;
    }
    .btn-danger:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #94a3b8;
    }
</style>

<div class="container-fluid">

    <div class="page-header">
        <div class="header-icon">
            <i class="fa-solid fa-file-signature"></i>
        </div>
        <div class="header-text">
            <h2>Verifikasi Peminjaman</h2>
            <p>Tinjau dan setujui permintaan peminjaman alat medis dari tenaga medis.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th><i class="fa-solid fa-user-md" style="margin-right:8px;"></i>Peminjam</th>
                    <th><i class="fa-solid fa-box-archive" style="margin-right:8px;"></i>Alat & Detail</th>
                    <th><i class="fa-solid fa-calendar-alt" style="margin-right:8px;"></i>Durasi</th>
                    <th><i class="fa-solid fa-shield-halved" style="margin-right:8px;"></i>Status</th>
                    <th style="text-align:center;">Tindakan</th>
                </tr>
            </thead>

            <tbody>
                @forelse($peminjaman as $item)
                <tr>
                    <td style="color: #cbd5e1; font-weight: 800;">{{ $loop->iteration }}</td>

                    <td style="font-weight: 700; color: #1e293b;">
                        {{ optional($item->user)->name ?? '-' }}
                        <div style="font-size: 11px; color: #94a3b8; font-weight: 600; margin-top: 2px;">
                            ID: #PINJAM-{{ $item->id }}
                        </div>
                    </td>

                    <td>
                        <div class="alat-wrapper">
                            @if($item->detail)
                                @foreach($item->detail as $d)
                                    @php
                                        $alat = $d->alat ?? null;
                                        $image = ($alat && $alat->gambar && file_exists(public_path('storage/'.$alat->gambar)))
                                            ? asset('storage/'.$alat->gambar)
                                            : asset('images/no-image.png');
                                    @endphp
                                    <div class="alat-item">
                                        <img src="{{ $image }}" class="alat-img">
                                        <div class="alat-info">
                                            <b>{{ $alat->nama_alat ?? '-' }}</b>
                                            <small>Qty: {{ $d->qty }} Unit</small>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <span style="color: #cbd5e1;">-</span>
                            @endif
                        </div>
                    </td>

                    <td style="font-weight: 600; color: #475569;">
                        <div style="display: flex; flex-direction: column; gap: 4px;">
                            <span style="font-size: 12px; color: #94a3b8;">{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-' }}</span>
                            <i class="fa-solid fa-arrow-down" style="font-size: 10px; color: #3b4bff; margin-left: 15px;"></i>
                            <span style="font-size: 12px; color: #3b4bff;">{{ $item->tanggal_kembali ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') : '-' }}</span>
                        </div>
                    </td>

                    <td>
                        <span class="status {{ $item->status }}">
                            <i class="fa-solid fa-circle" style="font-size: 6px;"></i>
                            {{ ucfirst($item->status ?? '-') }}
                        </span>
                    </td>

                    <td>
                        <div class="btn-group" style="justify-content: center;">
                            @if($item->status == 'menunggu')
                                <form action="{{ route('petugas.setujui',$item->id) }}" method="POST"
                                      onsubmit="return confirm('Setujui peminjaman ini?')">
                                    @csrf
                                    <button class="btn btn-primary">
                                        <i class="fa-solid fa-check-double"></i> Setujui
                                    </button>
                                </form>

                                <form action="{{ route('petugas.tolak',$item->id) }}" method="POST"
                                      onsubmit="return confirm('Tolak peminjaman ini?')">
                                    @csrf
                                    <button class="btn btn-danger">
                                        <i class="fa-solid fa-xmark"></i> Tolak
                                    </button>
                                </form>
                            @else
                                <span style="font-size:12px; color:#cbd5e1; font-style: italic;">Selesai Diproses</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-state">
                        <i class="fa-solid fa-inbox fa-3x" style="display: block; margin-bottom: 15px; opacity: 0.1;"></i>
                        Belum ada permintaan peminjaman yang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
