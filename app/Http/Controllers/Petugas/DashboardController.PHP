<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// MODELS
use App\Models\Alat;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $totalAlat = Alat::sum('stok') ?? 0;

        $alatTersedia = Alat::where('stok', '>', 0)->sum('stok') ?? 0;

        $menunggu = Peminjaman::where('status', 'menunggu')->count();

        $pengembalianHariIni = Peminjaman::where('status', 'kembali')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        // FIX: Karena kolom tgl_kembali gak ada, kita set 0 aja dulu biar gak error
        // Atau kalau kamu punya kolom lain (misal: tanggal_harus_kembali), ganti namanya di sini
        $terlambat = 0;

        // 2. Aktivitas Terbaru
        $aktivitas = Peminjaman::with(['user'])
            ->latest()
            ->take(6)
            ->get();

        // 3. Alat Terlaris (Top 5)
        // Saya sederhanakan querynya biar gak bentrok sama relasi yang belum ada
        $alatPopuler = Alat::orderBy('stok', 'asc')
            ->take(5)
            ->get();

        // 4. Logika Chart: 7 hari terakhir
        $chartData = Peminjaman::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $chartLabels = $chartData->pluck('date')->map(function($date) {
            return Carbon::parse($date)->format('d M');
        });

        $chartValues = $chartData->pluck('total');

        return view('petugas.dashboard', compact(
            'totalAlat',
            'alatTersedia',
            'menunggu',
            'terlambat',
            'pengembalianHariIni',
            'aktivitas',
            'alatPopuler',
            'chartLabels',
            'chartValues'
        ));
    }
}
