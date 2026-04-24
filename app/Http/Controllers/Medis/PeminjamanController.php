<?php

namespace App\Http\Controllers\Medis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Alat;
use App\Models\Notif; // Tambahkan ini
use App\Models\User;  // Tambahkan ini untuk cari Petugas
use Illuminate\Support\Facades\DB;

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

        DB::beginTransaction();

        try {
            // CREATE PEMINJAMAN
            $peminjaman = Peminjaman::create([
                'user_id' => Auth::id(),
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'keperluan' => $request->keperluan,
                'status' => 'menunggu'
            ]);

            $daftarAlat = [];

            // LOOP CART
            foreach ($request->selected_items as $id) {
                if (isset($cart[$id])) {
                    $qty = $cart[$id]['qty'];
                    $alat = Alat::find($id);

                    if ($alat) {
                        // Cek Stok Kembali (Double Check)
                        if ($alat->stok < $qty) {
                            throw new \Exception("Stok " . $alat->nama_alat . " tidak mencukupi.");
                        }

                        // SIMPAN DETAIL
                        DetailPeminjaman::create([
                            'peminjaman_id' => $peminjaman->id,
                            'alat_id' => $id,
                            'qty' => $qty
                        ]);

                        // KURANGI STOK
                        $alat->stok = max(0, $alat->stok - $qty);
                        $alat->save();

                        $daftarAlat[] = $alat->nama_alat;
                    }
                    unset($cart[$id]);
                }
            }

            // 🔥 KIRIM NOTIF KE SEMUA PETUGAS & ADMIN
            $petugasList = User::whereIn('role', ['petugas', 'admin'])->get();
            $namaMedis = auth()->user()->name;

            foreach ($petugasList as $petugas) {
                Notif::create([
                    'user_id' => $petugas->id,
                    'judul'   => '📩 Pengajuan Peminjaman',
                    'pesan'   => "<strong>$namaMedis</strong> mengajukan peminjaman: (" . implode(', ', $daftarAlat) . "). Segera periksa di daftar persetujuan.",
                    'is_read' => false
                ]);
            }

            DB::commit();
            session()->put('cart', $cart);

            return redirect()->route('medis.dashboard')
                ->with('success', 'Peminjaman berhasil diajukan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    // ================= AJUKAN PENGEMBALIAN =================
    public function ajukanPengembalian($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // pastikan hanya yang masih dipinjam
        if ($peminjaman->status != 'dipinjam') {
            return back()->with('error', 'Tidak bisa ajukan pengembalian');
        }

        $peminjaman->update([
            'status' => 'diajukan'
        ]);

        // 🔥 KIRIM NOTIF KE PETUGAS
        $petugasList = User::whereIn('role', ['petugas', 'admin'])->get();
        foreach ($petugasList as $petugas) {
            Notif::create([
                'user_id' => $petugas->id,
                'judul'   => '📦 Ajuan Pengembalian',
                'pesan'   => "User <strong>" . auth()->user()->name . "</strong> ingin mengembalikan alat untuk transaksi #$id.",
                'is_read' => false
            ]);
        }

        return back()->with('success', 'Pengembalian berhasil diajukan');
    }
}
