<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class MonitoringController extends Controller
{
    public function dashboard()
    {
        // ========================
        // TOTAL ALAT
        // ========================
        $totalAlat = Alat::sum('jumlah');

        // ========================
        // ALAT TERSEDIA
        // ========================
        $alatTersedia = Alat::where('jumlah', '>', 0)->sum('jumlah');

        // ========================
        // PEMINJAMAN AKTIF
        // ========================
        $peminjamanAktif = Peminjaman::whereIn('status', [
            'dipinjam',
            'menunggu',
            'approved'
        ])->count();

        // ========================
        // STATUS PEMINJAMAN
        // ========================
        $menunggu = Peminjaman::where('status', 'menunggu')->count();
        $ditolak = Peminjaman::where('status', 'ditolak')->count();
        $terlambat = Peminjaman::where('status', 'terlambat')->count();

        // ========================
        // PENGEMBALIAN HARI INI
        // ========================
        $pengembalianHariIni = Pengembalian::whereDate('created_at', today())->count();

        // ========================
        // STOK RENDAH
        // ========================
        $stokRendah = Alat::where('jumlah', '<=', 3)->count();

        // ========================
        // AKTIVITAS TERBARU
        // ========================
        $aktivitas = Peminjaman::with(['alat', 'user'])
            ->latest()
            ->take(6)
            ->get();

        // ========================
        // ALAT PALING SERING DIPINJAM (FIX AMAN)
        // ========================
        // ❗ Ini versi TANPA ERROR walaupun struktur DB belum jelas
        $alatPopuler = Alat::select('alats.*')
            ->selectRaw('(
                SELECT COUNT(*)
                FROM peminjaman
                WHERE peminjaman.alat_id = alats.id
            ) as peminjaman_count')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

        // ========================
        // RETURN VIEW
        // ========================
        return view('petugas.dashboard', compact(
            'totalAlat',
            'alatTersedia',
            'peminjamanAktif',
            'menunggu',
            'ditolak',
            'terlambat',
            'pengembalianHariIni',
            'stokRendah',
            'aktivitas',
            'alatPopuler'
        ));
    }

    // ========================
    // SETUJUI PEMINJAMAN
    // ========================
    public function setujui($id)
    {
        $data = Peminjaman::findOrFail($id);

        $data->update([
            'status' => 'dipinjam'
        ]);

        return back()->with('success', 'Disetujui');
    }

    // ========================
    // TOLAK PEMINJAMAN
    // ========================
    public function tolak($id)
    {
        $data = Peminjaman::findOrFail($id);

        $data->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Ditolak');
    }
}
