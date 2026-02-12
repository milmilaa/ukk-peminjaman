<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())->get();

        return view('siswa.dashboard', compact('peminjaman'));
    }
}
