<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Notif;
use DB;

class PeminjamanController extends Controller
{
    // Lihat daftar semua yang minta pinjam
    public function index()
    {
        $peminjaman = Peminjaman::with('user', 'detail.alat')
            ->where('status', 'menunggu')
            ->latest()
            ->get();
        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    // Tombol SETUJUI
    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'dipinjam']);

        // 🔥 Kirim Notif Balik ke Medis
        Notif::create([
            'user_id' => $peminjaman->user_id,
            'judul'   => '✅ Pinjaman Disetujui',
            'pesan'   => 'Alat medis sudah bisa diambil di ruang sarpras.',
            'is_read' => false
        ]);

        return back()->with('success', 'Berhasil disetujui!');
    }

    // Tombol TOLAK
    public function tolak($id)
    {
        $peminjaman = Peminjaman::with('detail.alat')->findOrFail($id);

        // Kembalikan stok karena batal pinjam
        foreach ($peminjaman->detail as $detail) {
            $detail->alat->increment('stok', $detail->qty);
        }

        $peminjaman->update(['status' => 'ditolak']);

        // 🔥 Kirim Notif Balik ke Medis
        Notif::create([
            'user_id' => $peminjaman->user_id,
            'judul'   => '❌ Pinjaman Ditolak',
            'pesan'   => 'Maaf, pengajuan Anda ditolak petugas.',
            'is_read' => false
        ]);

        return back()->with('success', 'Pesanan ditolak.');
    }
}
