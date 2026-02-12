<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;

class PeminjamanController extends Controller
{
    public function store()
    {
        $cart = session()->get('cart');

        if(!$cart){
            return back()->with('error','Cart kosong');
        }

        foreach($cart as $id => $item){

            $alat = Alat::find($id);

            if($alat->stok < $item['jumlah']){
                return back()->with('error','Stok tidak cukup');
            }

            Peminjaman::create([
                'user_id' => auth()->id(),
                'alat_id' => $id,
                'jumlah' => $item['jumlah'],
                'status' => 'menunggu'
            ]);

            $alat->decrement('stok', $item['jumlah']);
        }

        session()->forget('cart');

        return redirect()->route('siswa.dashboard')
            ->with('success','Peminjaman diajukan');
    }
}
