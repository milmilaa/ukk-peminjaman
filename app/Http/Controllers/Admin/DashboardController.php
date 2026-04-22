<?php

namespace App\Http\Controllers\Admin;

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
        // ========================
        // TOTAL STOK ALAT
        // ========================
        $totalAlat = Alat::sum('jumlah');

        // ========================
        // PEMINJAMAN AKTIF
        // ========================
        $peminjamanAktif = Peminjaman::whereIn('status', [
            'dipinjam',
            'menunggu'
        ])->count();

        // ========================
        // PENGEMBALIAN HARI INI
        // ========================
        $pengembalianHariIni = Pengembalian::whereDate(
            'created_at',
            now()->toDateString()
        )->count();

        // ========================
        // MENUNGGU PERSETUJUAN
        // ========================
        $menunggu = Peminjaman::where('status', 'menunggu')->count();

        // ========================
        // DITOLAK
        // ========================
        $ditolak = Peminjaman::where('status', 'ditolak')->count();

        // ========================
        // STOK RENDAH
        // ========================
        $stokRendah = Alat::where('jumlah', '<=', 3)->count();

        // ========================
        // TERLAMBAT
        // ========================
        $terlambat = Peminjaman::where('status', 'terlambat')->count();

        // ========================
        // AKTIVITAS TERBARU
        // ========================
        $aktivitas = Peminjaman::with(['alat', 'user'])
            ->latest()
            ->take(5)
            ->get();

        // ========================
        // ALAT PALING SERING DIPINJAM (FIX AMAN TANPA RELASI)
        // ========================
        $alatPopuler = Alat::select('alat.*')
            ->selectRaw('(
                SELECT COUNT(*)
                FROM peminjaman
                WHERE peminjaman.alat_id = alat.id
            ) as peminjaman_count')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

        // ========================
        // RETURN VIEW
        // ========================
        return view('dashboard', compact(
            'totalAlat',
            'peminjamanAktif',
            'pengembalianHariIni',
            'menunggu',
            'ditolak',
            'stokRendah',
            'terlambat',
            'aktivitas',
            'alatPopuler'
        ));
    }
}
