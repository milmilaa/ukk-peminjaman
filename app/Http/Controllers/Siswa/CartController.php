<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Alat;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('siswa.cart', compact('cart'));
    }

    public function add($id)
    {
        $alat = Alat::findOrFail($id);

        if($alat->stok < 1){
            return back()->with('error','Stok habis');
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$id])){
            $cart[$id]['jumlah']++;
        } else {
            $cart[$id] = [
                'nama' => $alat->nama,
                'jumlah' => 1
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success','Ditambahkan ke cart');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        unset($cart[$id]);

        session()->put('cart', $cart);

        return back()->with('success','Dihapus dari cart');
    }
}
