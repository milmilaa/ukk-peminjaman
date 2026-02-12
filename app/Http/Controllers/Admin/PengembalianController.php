<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // INDEX
    public function index()
    {
        $pengembalians = Pengembalian::with([
            'peminjaman.user',
            'peminjaman.alat'
        ])->latest()->get();

        return view('pengembalian.index', compact('pengembalians'));
    }

    // CREATE
    public function create()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->where('status', 'dipinjam')
            ->get();

        return view('pengembalian.create', compact('peminjamans'));
    }

    // STORE
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id'   => 'required|exists:peminjaman,id',
            'tanggal_kembali' => 'required|date',
            'kondisi'         => 'required',
        ]);

        $peminjaman = Peminjaman::with('alat')->findOrFail($request->peminjaman_id);

        // SIMPAN PENGEMBALIAN
        Pengembalian::create([
            'peminjaman_id'   => $request->peminjaman_id,
            'tanggal_kembali' => $request->tanggal_kembali,
            'kondisi'         => $request->kondisi,
            'catatan'         => $request->catatan,
        ]);

        // UPDATE STATUS PEMINJAMAN
        $peminjaman->update([
            'status' => 'dikembalikan',
        ]);

        // KEMBALIKAN STOK ALAT
        $peminjaman->alat->increment('stok', $peminjaman->jumlah);

        return redirect()->route('pengembalian.index')
            ->with('success', 'Pengembalian berhasil dicatat');
    }
}
