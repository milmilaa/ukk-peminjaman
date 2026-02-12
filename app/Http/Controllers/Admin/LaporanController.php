<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * LAPORAN PEMINJAMAN
     */
    public function peminjaman()
    {
        $peminjaman = Peminjaman::with(['user', 'alat'])
            ->latest()
            ->get();

        return view('laporan.peminjaman', compact('peminjaman'));
    }

    /**
     * LAPORAN PENGEMBALIAN
     */
    public function pengembalian()
    {
        $pengembalian = Pengembalian::with([
                'peminjaman.user',
                'peminjaman.alat'
            ])
            ->latest()
            ->get();

        return view('laporan.pengembalian', compact('pengembalian'));
    }

    /**
     * SIMPAN DATA PENGEMBALIAN
     */
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id'   => 'required|exists:peminjaman,id',
            'tanggal_kembali' => 'required|date',
            'kondisi'         => 'required|string'
        ]);

        // simpan pengembalian
        $pengembalian = Pengembalian::create([
            'peminjaman_id'   => $request->peminjaman_id,
            'tanggal_kembali' => $request->tanggal_kembali,
            'kondisi'         => $request->kondisi,
        ]);

        // ambil data peminjaman
        $peminjaman = Peminjaman::with('alat')->findOrFail($request->peminjaman_id);

        // update status peminjaman
        $peminjaman->update([
            'status'          => 'dikembalikan',
            'tanggal_kembali' => $request->tanggal_kembali,
        ]);

        // kembalikan stok alat
        $peminjaman->alat->increment('stok', $peminjaman->jumlah);

        return redirect()->back()
            ->with('success', 'Pengembalian berhasil dicatat');
    }

    /**
     * CETAK LAPORAN
     */
    public function cetak()
    {
        $peminjaman = Peminjaman::with(['user', 'alat'])->latest()->get();
        $pengembalian = Pengembalian::with([
                'peminjaman.user',
                'peminjaman.alat'
            ])
            ->latest()
            ->get();

        return view('laporan.cetak', compact('peminjaman', 'pengembalian'));
    }
}
