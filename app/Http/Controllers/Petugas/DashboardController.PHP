<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// MODELS
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // TOTAL ALAT (STOK)
        // =========================
        $totalAlat = Alat::sum('jumlah');

        // =========================
        // ALAT TERSEDIA
        // =========================
        $alatTersedia = Alat::where('jumlah', '>', 0)->sum('jumlah');

        // =========================
        // PEMINJAMAN AKTIF
        // =========================
        $peminjamanAktif = Peminjaman::whereIn('status', [
            'dipinjam',
            'menunggu',
            'approved'
        ])->count();

        // =========================
        // MENUNGGU PERSETUJUAN
        // =========================
        $menunggu = Peminjaman::where('status', 'menunggu')->count();

        // =========================
        // DISETUJUI / DIPINJAM
        // =========================
        $dipinjam = Peminjaman::where('status', 'dipinjam')->count();

        // =========================
        // DITOLAK
        // =========================
        $ditolak = Peminjaman::where('status', 'ditolak')->count();

        // =========================
        // TERLAMBAT PENGEMBALIAN
        // =========================
        $terlambat = Peminjaman::where('status', 'terlambat')->count();

        // =========================
        // PENGEMBALIAN HARI INI
        // =========================
        $pengembalianHariIni = Pengembalian::whereDate('created_at', today())->count();

        // =========================
        // STOK RENDAH
        // =========================
        $stokRendah = Alat::where('jumlah', '<=', 3)->count();

        // =========================
        // AKTIVITAS TERBARU
        // =========================
        $aktivitas = Peminjaman::with(['alat', 'user'])
            ->latest()
            ->take(6)
            ->get();

        // =========================
        // ALAT PALING SERING DIPINJAM
        // =========================
        $alatPopuler = Alat::withCount('peminjaman')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

        // =========================
        // RETURN VIEW
        // =========================
        return view('petugas.dashboard', compact(
            'totalAlat',
            'alatTersedia',
            'peminjamanAktif',
            'menunggu',
            'dipinjam',
            'ditolak',
            'terlambat',
            'pengembalianHariIni',
            'stokRendah',
            'aktivitas',
            'alatPopuler'
        ));
    }
}
