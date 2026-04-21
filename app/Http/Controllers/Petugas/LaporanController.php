<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{

    /* halaman laporan */
    public function index()
    {
        $peminjaman = Peminjaman::with('user','alat')->latest()->get();

        return view('petugas.laporan.index', compact('peminjaman'));
    }

    /* export excel */
    public function excel()
    {
        return Excel::download(new LaporanExport, 'laporan_peminjaman.xlsx');
    }

    /* export pdf */
    public function pdf()
    {
        $peminjaman = Peminjaman::with('user','alat')->get();

        $pdf = Pdf::loadView('petugas.laporan.cetak', compact('peminjaman'));

        return $pdf->download('laporan_peminjaman.pdf');
    }

    /* halaman cetak */
    public function cetakPeminjaman()
{
    $peminjaman = \App\Models\Peminjaman::with(['alat', 'user'])
        ->latest()
        ->get();

    return view('petugas.cetak-peminjaman', compact('peminjaman'));
}

}
