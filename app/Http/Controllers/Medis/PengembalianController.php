<?php

namespace App\Http\Controllers\Medis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Peminjaman;
use App\Models\Alat;

class PengembalianController extends Controller
{
    public function store($id)
    {
        $peminjaman = Peminjaman::with('detail.alat')->findOrFail($id);

        // ❌ kalau belum disetujui
        if ($peminjaman->status != 'disetujui') {
            return back()->with('error','Belum bisa dikembalikan');
        }

        // 🔥 KEMBALIKAN STOK
        foreach ($peminjaman->detail as $detail) {

            $alat = $detail->alat;

            if ($alat) {
                $alat->increment('stok', $detail->qty);
            }
        }

        // 🔥 UPDATE STATUS
        $peminjaman->status = 'dikembalikan';
        $peminjaman->tanggal_dikembalikan = now();

        // 🔥 CEK DENDA
        if (now()->gt($peminjaman->tanggal_kembali)) {

            $telat = now()->diffInDays($peminjaman->tanggal_kembali);

            // contoh denda 5000 / hari
            $peminjaman->denda = $telat * 5000;
        } else {
            $peminjaman->denda = 0;
        }

        $peminjaman->save();

        return redirect()->route('medis.dashboard')
            ->with('success','Alat berhasil dikembalikan');
    }
}
