<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class MonitoringController extends Controller
{
    // ========================
    // DASHBOARD
    // ========================
    public function dashboard()
    {
        $totalAlat = Alat::sum('jumlah');

        $alatTersedia = Alat::where('jumlah', '>', 0)->sum('jumlah');

        $peminjamanAktif = Peminjaman::whereIn('status', [
            'dipinjam',
            'menunggu',
            'approved'
        ])->count();

        $menunggu = Peminjaman::where('status', 'menunggu')->count();
        $ditolak = Peminjaman::where('status', 'ditolak')->count();
        $terlambat = Peminjaman::where('status', 'terlambat')->count();

        $pengembalianHariIni = Pengembalian::whereDate('created_at', today())->count();

        $stokRendah = Alat::where('jumlah', '<=', 3)->count();

        $aktivitas = Peminjaman::with(['user', 'detail.alat'])
            ->latest()
            ->take(6)
            ->get();

        // 🔥 FIX UTAMA: pakai detail_peminjaman, bukan peminjaman.alat_id
        $alatPopuler = Alat::select('alat.*')
            ->selectRaw('(
                SELECT COUNT(*)
                FROM detail_peminjaman
                WHERE detail_peminjaman.alat_id = alat.id
            ) as peminjaman_count')
            ->orderByDesc('peminjaman_count')
            ->take(5)
            ->get();

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
    // HALAMAN SETUJUI PEMINJAMAN
    // ========================
    public function menyetujui()
    {
        $peminjaman = Peminjaman::with(['user', 'detail.alat'])
            ->latest()
            ->get();

        return view('petugas.peminjaman', compact('peminjaman'));
    }

    // ========================
    // SETUJUI
    // ========================
    public function setujui($id)
    {
        $data = Peminjaman::findOrFail($id);

        $data->update([
            'status' => 'dipinjam'
        ]);

        return back()->with('success', 'Peminjaman disetujui');
    }

    // ========================
    // TOLAK
    // ========================
    public function tolak($id)
    {
        $data = Peminjaman::findOrFail($id);

        $data->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }

    // ========================
    // HALAMAN PENGEMBALIAN
    // ========================
    public function pengembalian()
    {
        $peminjaman = Peminjaman::with(['user', 'detail.alat'])
            ->where('status', 'dipinjam')
            ->latest()
            ->get();

        return view('petugas.pengembalian', compact('peminjaman'));
    }
}
