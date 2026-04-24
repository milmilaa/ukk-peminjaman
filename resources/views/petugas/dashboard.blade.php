@extends('layouts.app')
@section('title', 'Dashboard Petugas')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root {
        --bg-light: #f1f5f9;
        --panel-white: #ffffff;
        --border-color: #e2e8f0;
        --text-main: #1e293b;
        --text-muted: #64748b;
        --primary-blue: #2563eb;
        --accent-amber: #f59e0b;
        --accent-red: #e11d48;
    }

    body { background-color: var(--bg-light); color: var(--text-main); font-family: 'Inter', sans-serif; }
    .dashboard-header { margin-bottom: 24px; }
    .dashboard-header h1 { font-size: 24px; font-weight: 700; margin: 0; }
    .dashboard-header p { color: var(--text-muted); font-size: 14px; margin-top: 4px; }

    .stats-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px; }
    .stat-card { background: var(--panel-white); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); }
    .stat-label { display: block; font-size: 11px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; }
    .stat-number { font-size: 28px; font-weight: 700; }

    .main-grid { display: grid; grid-template-columns: 1fr 380px; gap: 20px; margin-bottom: 24px; }
    @media (max-width: 1024px) { .main-grid { grid-template-columns: 1fr; } }

    .content-panel { background: var(--panel-white); border-radius: 8px; border: 1px solid var(--border-color); padding: 20px; }
    .content-panel h3 { font-size: 15px; font-weight: 700; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid #f8fafc; }

    .table-custom { width: 100%; border-collapse: collapse; font-size: 13px; }
    .table-custom th { text-align: left; color: var(--text-muted); font-weight: 600; padding: 12px; border-bottom: 2px solid var(--bg-light); }
    .table-custom td { padding: 12px; border-bottom: 1px solid var(--bg-light); }

    .badge-status { padding: 4px 8px; border-radius: 4px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
    .bg-wait { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
    .bg-active { background: #dcfce7; color: #15803d; border: 1px solid #a7f3d0; }
    .bg-danger { background: #fee2e2; color: #b91c1c; border: 1px solid #fecdd3; }
</style>

<div class="dashboard-header">
    <h1>Dashboard Petugas</h1>
    <p>Data inventaris dan aktivitas peminjaman hari ini.</p>
</div>

<div class="stats-container">
    <div class="stat-card">
        <span class="stat-label">Total Unit Alat</span>
        <span class="stat-number">{{ number_format($totalAlat) }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-label" style="color: var(--accent-amber);">Menunggu Konfirmasi</span>
        <span class="stat-number">{{ $menunggu }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-label">Kembali Hari Ini</span>
        <span class="stat-number">{{ $pengembalianHariIni }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-label" style="color: var(--accent-red);">Terlambat</span>
        <span class="stat-number">{{ $terlambat }}</span>
    </div>
</div>

<div class="main-grid">
    <div class="content-panel">
        <h3>Statistik Peminjaman</h3>
        <div style="height: 300px;">
            <canvas id="loanChart"></canvas>
        </div>
    </div>

    <div class="content-panel">
        <h3>Alat Terlaris</h3>
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Nama Alat</th>
                    <th style="text-align: right;">Dipinjam</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alatPopuler as $alat)
                <tr>
                    <td>{{ $alat->nama_alat }}</td>
                    <td style="text-align: right; font-weight: 700; color: var(--primary-blue);">
                        {{ $alat->peminjaman_count }}x
                    </td>
                </tr>
                @empty
                <tr><td colspan="2" style="text-align:center; padding:20px; color:var(--text-muted);">Belum ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="content-panel">
    <h3>Data Peminjaman Terbaru</h3>
    <div style="overflow-x: auto;">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Alat</th>
                    <th>Tanggal Pinjam</th>
                    <th style="text-align: right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($aktivitas as $item)
                <tr>
                    <td><strong>{{ $item->user->name ?? '-' }}</strong></td>
                    <td>{{ $item->alat->nama_alat ?? '-' }}</td>
                    <td style="color: var(--text-muted);">{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    <td style="text-align: right;">
                        <span class="badge-status
                            {{ $item->status == 'menunggu' ? 'bg-wait' : '' }}
                            {{ in_array($item->status, ['dipinjam', 'approved', 'kembali']) ? 'bg-active' : '' }}
                            {{ in_array($item->status, ['ditolak', 'terlambat']) ? 'bg-danger' : '' }}">
                            {{ $item->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align:center; padding:30px; color:var(--text-muted);">Tidak ada aktivitas terbaru</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById('loanChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Jumlah Pinjaman',
                    data: {!! json_encode($chartValues) !!},
                    backgroundColor: '#2563eb',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endsection
