<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::orderBy('id', 'asc')->get();
        return view('alat.index', compact('alat'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('alat.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'jumlah'      => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_alat','kategori_id','jumlah']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('alat','public');
        }

        Alat::create($data);

        return redirect()->route('admin.alat.index')
            ->with('success','Alat berhasil ditambahkan');
    }

    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('alat.edit', compact('alat','kategoris'));
    }

    public function update(Request $request, Alat $alat)
    {
        $request->validate([
            'nama_alat'   => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id',
            'jumlah'      => 'required|integer|min:0',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['nama_alat','kategori_id','jumlah']);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('alat','public');
        }

        $alat->update($data);

        return redirect()->route('admin.alat.index')
            ->with('success','Alat berhasil diperbarui');
    }

    public function destroy(Alat $alat)
    {
        $alat->delete();

        return redirect()->route('admin.alat.index')
            ->with('success','Alat berhasil dihapus');
    }
}
