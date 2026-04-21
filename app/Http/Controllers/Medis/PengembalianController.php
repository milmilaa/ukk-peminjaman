<?php

namespace App\Http\Controllers\Medis;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;

class PengembalianController extends Controller
{
    public function store($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if($peminjaman->user_id != auth()->id()){
            abort(403);
        }

        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        Alat::where('id',$peminjaman->alat_id)
            ->increment('stok', $peminjaman->jumlah);

        return back()->with('success','Alat dikembalikan');
    }
}
