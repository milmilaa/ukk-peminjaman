@extends('layouts.app')

@section('title', 'Dashboard Professional - ALMEDIS')

@section('content')

@php
    $totalAlat = $totalAlat ?? 0;
    $peminjamanAktif = $peminjamanAktif ?? 0;
    $pengembalianHariIni = $pengembalianHariIni ?? 0;
    $menunggu = $menunggu ?? 0;
    $ditolak = $ditolak ?? 0;
    $stokRendah = $stokRendah ?? 0;
    $terlambat = $terlambat ?? 0;
    $aktivitas = $aktivitas ?? collect();
@endphp

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }

    :root {
        --primary: #4f46e5;
        --primary-soft: #eef2ff;
        --slate-800: #1e293b;
        --slate-500: #64748b;
        --glass-border: rgba(255, 255, 255, 0.7);
    }

    /* Header */
    .dashboard-header { margin-bottom: 30px; }
    .dashboard-header h1 { font-size: 28px; font-weight: 800; color: var(--slate-800); letter-spacing: -0.025em; margin: 0; }
    .dashboard-header p { color: var(--slate-500); font-size: 14px; margin-top: 4px; }

    /* Stats Grid (Top) */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .glass-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease;
    }
    .glass-card:hover { transform: translateY(-5px); }

    .icon-shape {
        width: 48px; height: 48px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; margin-bottom: 16px;
    }

    .stat-label { font-size: 13px; font-weight: 600; color: var(--slate-500); text-transform: uppercase; letter-spacing: 0.05em; }
    .stat-value { font-size: 32px; font-weight: 800; color: var(--slate-800); margin-top: 4px; }

    /* Layout Grid */
    .layout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 25px;
    }

    .section-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        padding: 28px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    /* Activity Style */
    .activity-row {
        display: flex; align-items: center; gap: 16px;
        padding: 16px 0; border-bottom: 1px solid #f1f5f9;
    }
    .activity-row:last-child { border: none; }

    .avatar-box {
        width: 44px; height: 44px; border-radius: 12px;
        background: var(--primary-soft); color: var(--primary);
        display: flex; align-items: center; justify-content: center; font-size: 18px;
    }

    .status-badge {
        padding: 5px 12px; border-radius: 100px; font-size: 11px; font-weight: 700;
        display: flex; align-items: center; gap: 6px;
    }
    .status-badge.wait { background: #fffbeb; color: #b45309; }
    .status-badge.done { background: #ecfdf5; color: #047857; }
    .status-badge.reject { background: #fef2f2; color: #b91c1c; }
    .dot { width: 6px; height: 6px; border-radius: 50%; }

    /* Dark Agenda Card */
    .agenda-card {
        background: #0f172a; color: white;
        border-radius: 24px; padding: 30px;
    }

    .btn-action {
        width: 100%; padding: 16px; background: var(--primary);
        color: white; border: none; border-radius: 16px;
        font-weight: 700; cursor: pointer; transition: 0.3s;
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.4);
    }
    .btn-action:hover { background: #4338ca; transform: translateY(-2px); }

    @media (max-width: 1024px) { .layout-grid { grid-template-columns: 1fr; } }
</style>

<div class="dashboard-header">
    <h1>Dashboard Overview</h1>
    <p>Monitoring logistik medis secara presisi hari ini.</p>
</div>

<div class="stats-container">
    <div class="glass-card">
        <div class="icon-shape" style="background: #eef2ff; color: #4f46e5;"><i class="fa-solid fa-boxes-stacked"></i></div>
        <div class="stat-label">Total Inventaris</div>
        <div class="stat-value">{{ $totalAlat }}</div>
    </div>
    <div class="glass-card">
        <div class="icon-shape" style="background: #ecfdf5; color: #10b981;"><i class="fa-solid fa-truck-fast"></i></div>
        <div class="stat-label">Peminjaman Aktif</div>
        <div class="stat-value">{{ $peminjamanAktif }}</div>
    </div>
    <div class="glass-card">
        <div class="icon-shape" style="background: #fffbeb; color: #f59e0b;"><i class="fa-solid fa-clock-rotate-left"></i></div>
        <div class="stat-label">Menunggu Izin</div>
        <div class="stat-value">{{ $menunggu }}</div>
    </div>
    <div class="glass-card" style="border-bottom: 4px solid #ef4444;">
        <div class="icon-shape" style="background: #fef2f2; color: #ef4444;"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div class="stat-label" style="color: #ef4444;">Stok Rendah</div>
        <div class="stat-value">{{ $stokRendah }}</div>
    </div>
</div>

<div class="section-card" style="margin-bottom: 30px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="margin: 0; font-size: 18px; font-weight: 700;">Tren Peminjaman Alat</h3>
        <span style="font-size: 12px; color: var(--slate-500); background: #f1f5f9; padding: 6px 12px; border-radius: 8px;">7 Hari Terakhir</span>
    </div>
    <div style="height: 320px;"><canvas id="mainChart"></canvas></div>
</div>

<div class="layout-grid">
    <div class="section-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 700;">Log Pantauan Alat</h3>
            <a href="#" style="font-size: 12px; color: var(--primary); text-decoration: none; font-weight: 700;">Lihat Semua</a>
        </div>

        <div class="activity-feed">
            @forelse($aktivitas as $item)
                <div class="activity-row">
                    <div class="avatar-box"><i class="fa-solid fa-hospital-user"></i></div>
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 14px; color: var(--slate-800);">
                            {{ $item->detail->first()->alat->nama_alat ?? 'Alat Medis' }}
                            @if($item->detail->count() > 1)
                                <span style="color: var(--primary); font-size: 11px;">+{{ $item->detail->count() - 1 }} item</span>
                            @endif
                        </strong>
                        <span style="font-size: 12px; color: var(--slate-500);">{{ $item->user->name ?? 'User' }} • {{ $item->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="status-badge
                        {{ $item->status == 'menunggu' ? 'wait' : '' }}
                        {{ in_array($item->status, ['dipinjam', 'approved', 'disetujui']) ? 'done' : '' }}
                        {{ in_array($item->status, ['ditolak', 'rejected']) ? 'reject' : '' }}">
                        <div class="dot" style="background: currentColor;"></div> {{ ucfirst($item->status) }}
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: var(--slate-500); padding: 20px;">Belum ada aktivitas.</p>
            @endforelse
        </div>
    </div>

    <div class="agenda-card">
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 25px;">
            <div style="background: rgba(255,255,255,0.1); width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-calendar-check" style="color: #fbbf24;"></i>
            </div>
            <span style="font-weight: 700; font-size: 17px;">Agenda Urgen</span>
        </div>

        <div style="margin-bottom: 25px;">
            <p style="color: #94a3b8; font-size: 12px; margin-bottom: 4px; font-weight: 600;">TARGET KEMBALI HARI INI</p>
            <div style="display: flex; align-items: baseline; gap: 8px;">
                <span style="font-size: 48px; font-weight: 800; color: #fbbf24;">{{ $pengembalianHariIni }}</span>
                <span style="font-size: 14px; color: #94a3b8;">Unit Alat</span>
            </div>
        </div>

        <div style="padding: 15px; background: rgba(255,255,255,0.03); border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 25px;">
            <p style="font-size: 13px; color: #94a3b8; line-height: 1.6; margin: 0;">
                <i class="fa-solid fa-circle-info" style="margin-right: 5px;"></i> Verifikasi unit yang masuk untuk menjaga ketersediaan stok operasional.
            </p>
        </div>

        <button class="btn-action">
            <i class="fa-solid fa-file-invoice" style="margin-right: 8px;"></i> Rekap Operasional
        </button>
    </div>
</div>

<script>
    const ctx = document.getElementById('mainChart').getContext('2d');

    // Create soft gradient for line chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.15)');
    gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Peminjaman',
                data: [12, 19, 15, 25, 22, 30, 45],
                borderColor: '#4f46e5',
                borderWidth: 3,
                fill: true,
                backgroundColor: gradient,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4f46e5',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8', font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { color: '#94a3b8', font: { size: 11 } } }
            }
        }
    });
</script>

@endsection
