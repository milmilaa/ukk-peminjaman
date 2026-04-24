<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::orderBy('id', 'asc')->get();
        return view('alat.index', compact('alat'));
    }

    public function create()
    {
        $kategoris = Kategori::orderBy('nama', 'asc')->get();
        return view('alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat'   => 'required|string',
            'stok'        => 'required|numeric|min:0',
            'harga'       => 'nullable|numeric|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validasi gambar
        ]);

        // Logika Upload Gambar
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('alat', 'public');
            $validated['gambar'] = $path;
        }

        Alat::create($validated);

        return redirect()->route('admin.alat.index')
            ->with('success', 'Data alat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $alat = Alat::findOrFail($id);
        $kategoris = Kategori::orderBy('nama', 'asc')->get();

        return view('alat.edit', compact('alat', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $alat = Alat::findOrFail($id);

        $validated = $request->validate([
            'nama_alat'   => 'required|string',
            'stok'        => 'required|numeric|min:0',
            'harga'       => 'nullable|numeric|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Logika Update Gambar
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($alat->gambar) {
                Storage::disk('public')->delete($alat->gambar);
            }

            // Simpan gambar baru
            $path = $request->file('gambar')->store('alat', 'public');
            $validated['gambar'] = $path;
        }

        $alat->update($validated);

        return redirect()->route('admin.alat.index')
            ->with('success', 'Data alat berhasil diupdate');
    }

    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        // Hapus file gambar dari folder storage sebelum hapus data
        if ($alat->gambar) {
            Storage::disk('public')->delete($alat->gambar);
        }

        $alat->delete();

        return redirect()->route('admin.alat.index')
            ->with('success', 'Data alat berhasil dihapus');
    }
}
