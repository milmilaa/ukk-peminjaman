<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notif;

class NotifController extends Controller
{
    /**
     * Menampilkan halaman daftar notifikasi milik user yang login
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil notifikasi khusus milik user yang sedang login
        $data = Notif::where('user_id', $user->id)
                     ->latest()
                     ->get();

        return view('notif.index', compact('data'));
    }

    /**
     * Menandai semua notifikasi milik user sebagai "Sudah Dibaca"
     * Digunakan oleh tombol 'Tandai Dibaca Semua' di view
     */
    public function markRead()
    {
        Notif::where('user_id', Auth::id())
             ->where('is_read', false)
             ->update(['is_read' => true]);

        return redirect()->back()->with('success', 'Semua notifikasi berhasil ditandai sudah dibaca.');
    }

    /**
     * Menghapus satu notifikasi tertentu
     */
    public function destroy($id)
    {
        $notif = Notif::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        $notif->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    /**
     * Menghapus semua notifikasi milik user (Kosongkan Inbox)
     */
    public function deleteAll()
    {
        Notif::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', 'Semua notifikasi berhasil dibersihkan.');
    }

    /**
     * Helper Static: Mengambil jumlah notif yang belum dibaca
     * Bisa dipanggil di Blade dengan: \App\Http\Controllers\NotifController::getUnreadCount()
     */
    public static function getUnreadCount()
    {
        if (Auth::check()) {
            return Notif::where('user_id', Auth::id())
                        ->where('is_read', false)
                        ->count();
        }
        return 0;
    }
}
