<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class MonitoringController extends Controller
{
    public function log()
    {
        $peminjaman = Peminjaman::latest()->get();
        return view('admin.monitoring.log', compact('peminjaman'));
    }
}
