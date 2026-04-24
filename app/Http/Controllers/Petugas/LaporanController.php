<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Exports\LaporanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN CETAK PEMINJAMAN (Halaman Utama Laporan)
    |--------------------------------------------------------------------------
    */
    public function cetakPeminjaman()
    {
        // Mengambil data peminjaman beserta relasi user, detail alat, dan pengembalian (untuk denda)
        $peminjaman = Peminjaman::with(['user', 'detail.alat', 'pengembalian'])
            ->latest()
            ->get();

        return view('petugas.cetak-peminjaman', compact('peminjaman'));
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN LAPORAN DENDA
    |--------------------------------------------------------------------------
    */
    public function laporanDenda()
    {
        // Mengambil data peminjaman yang HANYA memiliki denda melalui relasi pengembalian
        $peminjaman = Peminjaman::whereHas('pengembalian', function($query) {
                $query->where('denda', '>', 0);
            })
            ->with(['user', 'detail.alat', 'pengembalian'])
            ->latest()
            ->get();

        return view('petugas.cetak-peminjaman', compact('peminjaman'));
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function exportExcel()
    {
        return Excel::download(
            new LaporanExport,
            'laporan_peminjaman_' . date('Y-m-d') . '.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CETAK INVOICE / PDF PER TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function cetakInvoiceDenda($id)
    {
        $item = Peminjaman::with(['user', 'detail.alat', 'pengembalian'])
            ->findOrFail($id);

        // Memastikan file view 'petugas.invoice-pdf' tersedia
        // Jika belum ada, kamu bisa arahkan ke view cetak biasa dulu
        $pdf = Pdf::loadView('petugas.invoice-pdf', compact('item'));

        return $pdf->stream('invoice_' . $item->id . '.pdf');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF (SEMUA DATA)
    |--------------------------------------------------------------------------
    */
    public function exportPdf()
    {
        $peminjaman = Peminjaman::with(['user', 'detail.alat', 'pengembalian'])
            ->latest()
            ->get();

        $pdf = Pdf::loadView('petugas.cetak-peminjaman', compact('peminjaman'))
            ->setPaper('a4', 'landscape'); // Set landscape agar tabel muat

        return $pdf->download('laporan_peminjaman_full.pdf');
    }
}
