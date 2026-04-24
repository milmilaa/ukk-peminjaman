<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeminjamanExport;

class PeminjamanController extends Controller
{
    /* ================= INDEX ================= */
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'alat'])
            ->latest()
            ->get();

        // Jika error, coba ganti menjadi 'peminjam.index' atau 'admin.peminjaman.index'
        return view('peminjaman.index', compact('peminjamans'));
    }

    /* ================= CREATE ================= */
    public function create()
    {
        $users = User::where('role', 'medis')->get();
        $alats = Alat::all();

        return view('peminjaman.create', compact('users', 'alats'));
    }

    /* ================= STORE ================= */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'alat_id' => 'required',
            'stok' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        if ($request->stok > $alat->stok) {
            return back()->withErrors(['stok' => 'Stok tidak mencukupi!'])->withInput();
        }

        Peminjaman::create([
            'user_id' => $request->user_id,
            'alat_id' => $request->alat_id,
            'stok' => $request->stok,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'dipinjam'
        ]);

        $alat->decrement('stok', $request->stok);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Peminjaman berhasil ditambahkan');
    }

    /* ================= EDIT ================= */
    public function edit($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        /**
         * PERHATIKAN BARIS INI:
         * Jika folder kamu di resources/views/peminjaman/edit.blade.php -> gunakan 'peminjaman.edit'
         * Jika folder kamu di resources/views/peminjam/edit.blade.php -> gunakan 'peminjam.edit'
         */
        return view('peminjaman.edit', compact('peminjaman'));
    }

    /* ================= UPDATE ================= */
    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($id);

        $request->validate([
            'status' => 'required|in:dipinjam,dikembalikan',
            'tanggal_kembali' => 'required|date'
        ]);

        // Logika Stok
        if ($request->status === 'dikembalikan' && $peminjaman->status !== 'dikembalikan') {
            $peminjaman->alat->increment('stok', $peminjaman->stok);
        } elseif ($request->status === 'dipinjam' && $peminjaman->status === 'dikembalikan') {
            $peminjaman->alat->decrement('stok', $peminjaman->stok);
        }

        $peminjaman->update([
            'status' => $request->status,
            'tanggal_kembali' => $request->tanggal_kembali
        ]);

        return redirect()->route('admin.peminjaman.index')
            ->with('success', 'Status diperbarui');
    }

    /* ================= DELETE ================= */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($id);

        if ($peminjaman->status !== 'dikembalikan') {
            $peminjaman->alat->increment('stok', $peminjaman->stok);
        }

        $peminjaman->delete();
        return back()->with('success', 'Data dihapus');
    }

    /* ================= EXPORT ================= */
    public function exportExcel()
    {
        return Excel::download(new PeminjamanExport, 'peminjaman.xlsx');
    }
}
