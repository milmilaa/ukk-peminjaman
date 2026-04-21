<?php

namespace App\Http\Controllers\Medis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;

class PeminjamanController extends Controller
{
    // ================= AKTIVITAS =================
    public function aktivitas()
    {
        $peminjaman = Peminjaman::with('detail.alat')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('medis.aktivitas', compact('peminjaman'));
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong');
        }

        // 🔥 HEADER (TIDAK ADA alat_id)
        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'tanggal_pinjam' => now(),
            'status' => 'menunggu'
        ]);

        // 🔥 DETAIL
        foreach ($cart as $item) {
            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'alat_id' => $item['id'],
                'qty' => $item['qty']
            ]);
        }

        // 🔥 CLEAR CART
        session()->forget('cart');

        return redirect()->route('medis.dashboard')
            ->with('success', 'Peminjaman berhasil diajukan');
    }
}
