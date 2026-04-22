<?php

namespace App\Http\Controllers\Medis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Alat;

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

        // VALIDASI
        $request->validate([
            'selected_items'   => 'required|array',
            'keperluan'        => 'required|string',
            'tanggal_pinjam'   => 'required|date',
            'tanggal_kembali'  => 'required|date|after_or_equal:tanggal_pinjam'
        ]);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong');
        }

        // 🔥 CREATE PEMINJAMAN (TANPA alat_id!)
        $peminjaman = Peminjaman::create([
            'user_id' => Auth::id(),
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'keperluan' => $request->keperluan,
            'status' => 'menunggu'
        ]);

        // 🔥 LOOP CART ITEM
        foreach ($request->selected_items as $id) {

            if (isset($cart[$id])) {

                $qty = $cart[$id]['qty'];

                // SIMPAN DETAIL PEMINJAMAN
                DetailPeminjaman::create([
                    'peminjaman_id' => $peminjaman->id,
                    'alat_id' => $id,
                    'qty' => $qty
                ]);

                // KURANGI STOK
                $alat = Alat::find($id);
                if ($alat) {
                    $alat->jumlah = max(0, $alat->jumlah - $qty);
                    $alat->save();
                }

                // HAPUS CART
                unset($cart[$id]);
            }
        }

        // UPDATE SESSION CART
        session()->put('cart', $cart);

        return redirect()->route('medis.dashboard')
            ->with('success', 'Peminjaman berhasil diajukan!');
    }
}
