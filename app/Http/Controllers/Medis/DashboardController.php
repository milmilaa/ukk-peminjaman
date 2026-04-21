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
        // ========================
        // TOTAL ALAT (STOK)
        // ========================
        $totalAlat = Alat::sum('jumlah');

        // ========================
        // LIST ALAT TERBARU / TERSEDIA
        // ========================
        $alat = Alat::latest()->get();

        // ========================
        // PEMINJAMAN USER MEDIS (opsional tapi bagus)
        // ========================
        $peminjamanSaya = Peminjaman::with(['alat'])
            ->where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        // ========================
        // RETURN VIEW
        // ========================
        return view('medis.dashboard', [
            'totalAlat' => $totalAlat,
            'alat' => $alat,
            'peminjamanSaya' => $peminjamanSaya,
        ]);
    }
}
