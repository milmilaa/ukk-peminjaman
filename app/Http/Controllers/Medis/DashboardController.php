<?php

namespace App\Http\Controllers\Medis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// MODEL
use App\Models\Alat;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
{
    $alat = \App\Models\Alat::all();

    // 🔥 ambil riwayat + relasi
    $peminjaman = \App\Models\Peminjaman::with('detail.alat')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('medis.dashboard', compact('alat','peminjaman'));
}
}
