<?php

namespace App\Http\Controllers\Medis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// MODEL
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Notif; // Tambahkan ini sis

class DashboardController extends Controller
{
    public function index()
    {
        $alat = Alat::all();

        // 🔥 ambil riwayat + relasi
        $peminjaman = Peminjaman::with('detail.alat')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // 🔔 Hitung notifikasi yang belum dibaca khusus untuk user ini
        $unreadCount = Notif::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return view('medis.dashboard', compact('alat', 'peminjaman', 'unreadCount'));
    }
}
