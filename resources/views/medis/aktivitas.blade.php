@extends('layouts.app')

@section('title','Riwayat Peminjaman')

@section('content')

<style>
    /* Global Background untuk halaman ini */
    body {
        background-color: #f8fafc;
    }

    /* Header Styling */
    .page-header {
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .page-header h1 {
        font-size: 28px;
        font-weight: 800;
        color: #1e293b;
        letter-spacing: -0.025em;
        margin: 0;
    }
    .page-header p {
        font-size: 14px;
        color: #64748b;
        margin-top: 4px;
    }

    /* Container Wrap */
    .activity-container {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
    }

    /* Card Styling */
    .loan-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .loan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #3b82f6;
    }

    /* Badge Status */
    .status-badge {
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge.menunggu { background: #fef9c3; color: #a16207; border: 1px solid #fde047; }
    .status-badge.disetujui { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .status-badge.ditolak { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
    .status-badge.dipinjam { background: #dbeafe; color: #1d4ed8; border: 1px solid #bfdbfe; }

    /* Loan Info */
    .loan-id {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 8px;
    }
    .loan-date {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #94a3b8;
        margin-bottom: 20px;
    }

    /* Detail Section */
    .detail-section {
        background: #f1f5f9;
        border-radius: 14px;
        padding: 16px;
    }
    .detail-title {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 10px;
        display: block;
        text-transform: uppercase;
    }
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        border-bottom: 1px dashed #cbd5e1;
    }
    .detail-item:last-child { border-bottom: none; }
    .item-name { font-size: 14px; color: #334155; font-weight: 500; }
    .item-qty {
        font-size: 12px;
        background: #3b82f6;
        color: white;
        padding: 2px 8px;
        border-radius: 6px;
        font-weight: 600;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 24px;
        border: 2px dashed #e2e8f0;
    }
    .empty-state i {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }
    .empty-state p {
        color: #64748b;
        font-size: 16px;
    }
</style>

<div class="page-header">
    <div>
        <h1>Riwayat Peminjaman</h1>
        <p>Kelola dan pantau semua aktivitas peminjaman alat medis Anda.</p>
    </div>
</div>

<div class="activity-container">
    @forelse($peminjaman as $pinjam)
        <div class="loan-card">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div>
                    <div class="loan-id">ID Peminjaman #{{ $pinjam->id }}</div>
                    <div class="loan-date">
                        <i class="fa-regular fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}
                        <span style="color: #cbd5e1;">&rarr;</span>
                        {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}
                    </div>
                </div>
                <span class="status-badge {{ strtolower($pinjam->status) }}">
                    @if(strtolower($pinjam->status) == 'menunggu') ⏳ @endif
                    @if(strtolower($pinjam->status) == 'disetujui') ✅ @endif
                    @if(strtolower($pinjam->status) == 'ditolak') ❌ @endif
                    {{ ucfirst($pinjam->status) }}
                </span>
            </div>

            <div class="detail-section">
                <span class="detail-title">Detail Alat Medis</span>
                @foreach($pinjam->detail as $d)
                    <div class="detail-item">
                        <span class="item-name">{{ $d->alat->nama_alat ?? 'Alat tidak ditemukan' }}</span>
                        <span class="item-qty">{{ $d->qty }} Unit</span>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="empty-state">
            <i class="fa-solid fa-folder-open"></i>
            <p>Sepertinya Anda belum pernah melakukan peminjaman.</p>
            <a href="{{ route('medis.alat') }}" style="color: #3b82f6; font-weight: 600; text-decoration: none; margin-top: 10px; display: inline-block;">Mulai Pinjam Sekarang &rarr;</a>
        </div>
    @endforelse
</div>

@endsection
