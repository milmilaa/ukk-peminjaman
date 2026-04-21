<?php

namespace App\Http\Controllers\Medis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alat;

class CartController extends Controller
{
    // ================= VIEW CART =================
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('medis.cart', compact('cart'));
    }

    // ================= ADD TO CART =================
    public function add($id)
    {
        $alat = Alat::findOrFail($id);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = [
                'id' => $alat->id,
                'nama_alat' => $alat->nama_alat,

                // 🔥 FIX: samakan dengan field blade kamu
                'gambar' => $alat->foto ?? null,

                'qty' => 1
            ];
        }

        session()->put('cart', $cart);

        // ================= RESPONSE =================
        return redirect()->back()->with('success', 'Berhasil ditambahkan ke keranjang');

        // kalau mau AJAX nanti pakai ini:
        /*
        return response()->json([
            'success' => true,
            'total_item' => count($cart),
            'total_qty' => array_sum(array_column($cart, 'qty'))
        ]);
        */
    }

    // ================= UPDATE QTY (manual input kalau ada nanti) =================
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            $qty = (int) $request->qty;

            if ($qty < 1) {
                $qty = 1;
            }

            $cart[$id]['qty'] = $qty;
        }

        session()->put('cart', $cart);

        return back();
    }

    // ================= INCREASE =================
    public function increase($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty']++;
            session()->put('cart', $cart);
        }

        return back();
    }

    // ================= DECREASE =================
    public function decrease($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            if ($cart[$id]['qty'] > 1) {
                $cart[$id]['qty']--;
            } else {
                unset($cart[$id]); // kalau 1 langsung hapus
            }

            session()->put('cart', $cart);
        }

        return back();
    }

    // ================= REMOVE =================
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back();
    }

    // ================= CLEAR CART =================
    public function clear()
    {
        session()->forget('cart');

        return back();
    }

    // ================= OPTIONAL: GET CART COUNT (buat AJAX / navbar realtime) =================
    public function count()
    {
        $cart = session()->get('cart', []);

        $totalQty = array_sum(array_column($cart, 'qty'));

        return response()->json([
            'total_item' => count($cart),
            'total_qty' => $totalQty
        ]);
    }
}
