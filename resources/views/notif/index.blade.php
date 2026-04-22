@extends('layouts.app')

@section('title','Notifikasi')

@section('content')

<style>
.page-title {
    margin-bottom: 25px;
}

.page-title h1 {
    font-size: 26px;
    font-weight: 700;
    color: #111827;
    margin: 0;
}

.page-title span {
    font-size: 14px;
    color: #6b7280;
}

/* FILTER */
.filter-box{
    display:flex;
    gap:10px;
    margin-bottom:15px;
}

.filter-box a{
    padding:8px 14px;
    border-radius:10px;
    font-size:13px;
    text-decoration:none;
    background:#f3f4f6;
    color:#111827;
    transition:.2s;
}

.filter-box a.active,
.filter-box a:hover{
    background:#3b82f6;
    color:#fff;
}

/* CONTAINER */
.notif-wrapper {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

/* CARD */
.notif-card {
    display: flex;
    align-items: center;
    gap: 14px;
    background: #ffffff;
    padding: 16px;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.05);
    transition: all 0.25s ease;
    border: 1px solid #f1f5f9;
}

.notif-card:hover {
    transform: translateY(-3px);
}

/* ICON */
.notif-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    color: white;
}

/* STATUS */
.status-menunggu .notif-icon { background: #facc15; }
.status-disetujui .notif-icon { background: #22c55e; }
.status-ditolak .notif-icon { background: #ef4444; }

/* CONTENT */
.notif-content {
    flex: 1;
}

.notif-title-text {
    font-size: 15px;
    font-weight: 600;
}

.notif-desc {
    font-size: 13px;
    color: #6b7280;
    margin-top: 4px;
}

.notif-time {
    font-size: 12px;
    color: #9ca3af;
    margin-top: 6px;
}

/* ROLE BADGE */
.role-badge{
    font-size:11px;
    padding:3px 8px;
    border-radius:999px;
    margin-left:6px;
}

.role-admin{ background:#dbeafe; color:#1d4ed8; }
.role-petugas{ background:#fef3c7; color:#92400e; }

/* STATUS BADGE */
.badge-status {
    padding: 4px 10px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 600;
}

.badge-menunggu { background: #fef9c3; color: #854d0e; }
.badge-disetujui { background: #dcfce7; color: #166534; }
.badge-ditolak { background: #fee2e2; color: #991b1b; }

/* ACTION */
.notif-action{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.btn-small{
    font-size:12px;
    padding:6px 10px;
    border-radius:8px;
    border:none;
    cursor:pointer;
}

.btn-view{
    background:#3b82f6;
    color:#fff;
}

.btn-delete{
    background:#ef4444;
    color:#fff;
}

/* EMPTY */
.empty {
    background: #fff;
    padding: 40px;
    text-align: center;
    border-radius: 16px;
    color: #9ca3af;
}
</style>

<div class="page-title">
    <h1>Notifikasi</h1>
    <span>Informasi aktivitas peminjaman alat</span>
</div>

{{-- ================= FILTER ROLE ================= --}}
<div class="filter-box">
    <a href="?role=all" class="{{ request('role') == 'all' || !request('role') ? 'active' : '' }}">Semua</a>
    <a href="?role=admin" class="{{ request('role') == 'admin' ? 'active' : '' }}">Admin</a>
    <a href="?role=petugas" class="{{ request('role') == 'petugas' ? 'active' : '' }}">Petugas</a>
</div>

<div class="notif-wrapper">

@forelse($data as $item)

@php
    $status = strtolower($item->status);
    $role = optional($item->user)->role ?? 'petugas';
@endphp

<div class="notif-card status-{{ $status }}">

    {{-- ICON --}}
    <div class="notif-icon">
        @if($status == 'menunggu')
            ⏳
        @elseif($status == 'disetujui')
            ✔
        @elseif($status == 'ditolak')
            ✖
        @else
            🔔
        @endif
    </div>

    {{-- CONTENT --}}
    <div class="notif-content">

        <div class="notif-title-text">
            Peminjaman #{{ $item->id }}

            {{-- ROLE LABEL --}}
            <span class="role-badge role-{{ $role }}">
                {{ ucfirst($role) }}
            </span>
        </div>

        <div class="notif-desc">
            Status:
            <span class="badge-status badge-{{ $status }}">
                {{ ucfirst($item->status) }}
            </span>
        </div>

        <div class="notif-time">
            {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
        </div>

    </div>

    {{-- ACTION --}}
    <div class="notif-action">
        <button class="btn-small btn-view">Detail</button>

        @if(auth()->user()->role == 'admin')
        <button class="btn-small btn-delete">Hapus</button>
        @endif
    </div>

</div>

@empty

<div class="empty">
    <i class="fa-solid fa-bell-slash"></i>
    <p>Tidak ada notifikasi</p>
</div>

@endforelse

</div>

@endsection
