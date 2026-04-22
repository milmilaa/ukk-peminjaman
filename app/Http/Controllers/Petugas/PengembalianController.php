<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DetailPengembalian; 
use Carbon\Carbon;
use DB;

class PengembalianController extends Controller
{
    public function store($id, Request $request)
    {
        DB::beginTransaction();

        try {

            $peminjaman = Peminjaman::with('detail.alat')->findOrFail($id);

            if ($peminjaman->status == 'dikembalikan') {
                return back()->with('error', 'Barang sudah dikembalikan');
            }

            $totalDenda = 0;
            $breakdown = [];

            foreach ($peminjaman->detail as $detail) {

                $alat = $detail->alat;

                if ($alat) {
                    $alat->jumlah += $detail->qty;
                    $alat->save();

                    $kondisi = $request->kondisi ?? 'baik';

                    $dendaItem = 0;

                    if ($kondisi == 'rusak ringan') {
                        $dendaItem = 0.2 * ($alat->harga ?? 0);
                    } elseif ($kondisi == 'rusak berat') {
                        $dendaItem = 0.6 * ($alat->harga ?? 0);
                    } elseif ($kondisi == 'hilang') {
                        $dendaItem = 1 * ($alat->harga ?? 0);
                    }

                    $totalDenda += $dendaItem;

                    $breakdown[] = [
                        'alat_id' => $alat->id,
                        'alat' => $alat->nama_alat,
                        'kondisi' => $kondisi,
                        'denda' => $dendaItem
                    ];
                }
            }

            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => Carbon::now()
            ]);

            $pengembalian = Pengembalian::create([
                'peminjaman_id' => $peminjaman->id,
                'tanggal_kembali' => Carbon::now(),
                'kondisi' => $request->kondisi ?? 'baik',
                'denda' => $totalDenda,
                'status_denda' => $totalDenda > 0 ? 'belum_bayar' : 'lunas',
                'metode_bayar' => 'cash',
            ]);

            foreach ($breakdown as $item) {
                DetailPengembalian::create([
                    'pengembalian_id' => $pengembalian->id,
                    'alat_id' => $item['alat_id'],
                    'kondisi' => $item['kondisi'],
                    'denda' => $item['denda'],
                ]);
            }

            DB::commit();

            return back()->with('success', 'Pengembalian berhasil');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function bayarDenda($id)
    {
        $pengembalian = Pengembalian::where('peminjaman_id', $id)->firstOrFail();

        if ($pengembalian->status_denda == 'lunas') {
            return back()->with('error', 'Denda sudah lunas');
        }

        $pengembalian->update([
            'status_denda' => 'lunas',
            'metode_bayar' => 'cash',
            'tanggal_bayar' => Carbon::now(),
        ]);

        return back()->with('success', 'Denda berhasil dikonfirmasi lunas');
    }
}
