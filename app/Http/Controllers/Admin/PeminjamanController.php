<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])->latest()->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::where('role', 'siswa')->get();
        $alats = Alat::all();
        return view('peminjaman.create', compact('users', 'alats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'alat_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        if ($request->jumlah > $alat->jumlah) {
            return back()->withErrors(['jumlah' => 'Jumlah melebihi stok alat']);
        }

        Peminjaman::create([
            'user_id' => $request->user_id,
            'alat_id' => $request->alat_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam'
        ]);

        $alat->decrement('jumlah', $request->jumlah);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        return view('peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'status' => 'required'
        ]);

        if ($request->status === 'dikembalikan' && $peminjaman->status !== 'dikembalikan') {
            $peminjaman->alat->increment('jumlah', $peminjaman->jumlah);
        }

        $peminjaman->update([
            'status' => $request->status
        ]);

        return redirect()->route('peminjaman.index')
            ->with('success', 'Status peminjaman diperbarui');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'dikembalikan') {
            $peminjaman->alat->increment('jumlah', $peminjaman->jumlah);
        }

        $peminjaman->delete();

        return back()->with('success', 'Data peminjaman dihapus');
    }
}
