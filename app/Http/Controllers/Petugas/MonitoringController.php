<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Notif; // Tambahkan ini
use DB;

class MonitoringController extends Controller
{
    public function dashboard()
    {
        // Logika dashboard petugas kamu
        return view('petugas.dashboard');
    }

    public function menyetujui()
    {
        $peminjaman = Peminjaman::with('user', 'detail.alat')
            ->where('status', 'menunggu')
            ->latest()
            ->get();
        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    // ================= SETUJUI =================
    public function setujui($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::findOrFail($id);

            $peminjaman->update([
                'status' => 'dipinjam'
            ]);

            // 🔥 KIRIM NOTIF KE MEDIS
            Notif::create([
                'user_id' => $peminjaman->user_id,
                'judul'   => '✅ Peminjaman Disetujui',
                'pesan'   => "Pengajuan pinjaman Anda #$id telah disetujui. Silakan ambil alat medis di bagian sarpras.",
                'is_read' => false
            ]);

            DB::commit();
            return back()->with('success', 'Peminjaman disetujui & Notifikasi terkirim!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // ================= TOLAK =================
    public function tolak($id)
    {
        DB::beginTransaction();
        try {
            $peminjaman = Peminjaman::with('detail.alat')->findOrFail($id);

            // Balikin stok karena ditolak
            foreach ($peminjaman->detail as $detail) {
                $detail->alat->increment('stok', $detail->qty);
            }

            $peminjaman->update([
                'status' => 'ditolak'
            ]);

            // 🔥 KIRIM NOTIF KE MEDIS
            Notif::create([
                'user_id' => $peminjaman->user_id,
                'judul'   => '❌ Peminjaman Ditolak',
                'pesan'   => "Maaf, pengajuan pinjaman Anda #$id ditolak oleh petugas. Silakan hubungi admin untuk info lebih lanjut.",
                'is_read' => false
            ]);

            DB::commit();
            return back()->with('success', 'Peminjaman ditolak & Notifikasi terkirim!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function monitoring()
    {
        $peminjaman = Peminjaman::with('user', 'detail.alat')->latest()->get();
        return view('petugas.monitoring', compact('peminjaman'));
    }

    public function pengembalian()
    {
        // Ambil data yang statusnya 'diajukan' atau 'dipinjam'
        $peminjaman = Peminjaman::with('user', 'detail.alat')
            ->whereIn('status', ['dipinjam', 'diajukan', 'proses_pengembalian'])
            ->latest()
            ->get();
        return view('petugas.pengembalian.index', compact('peminjaman'));
    }
}   
