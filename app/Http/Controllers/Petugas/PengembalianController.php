<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Notif;
use App\Models\Alat;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    /**
     * STEP 1: MASUK PROSES
     * Dipanggil saat petugas klik 'Selesaikan' (input kondisi awal)
     */
    public function proses($id, Request $request)
    {
        DB::beginTransaction();

        try {
            $peminjaman = Peminjaman::with('user')->findOrFail($id);

            // Validasi agar tidak diproses dua kali
            if (in_array($peminjaman->status, ['dikembalikan', 'proses_pengembalian'])) {
                return back()->with('error', 'Transaksi ini sudah dalam proses atau sudah selesai.');
            }

            // Update status peminjaman ke tahap antara
            $peminjaman->update([
                'status' => 'proses_pengembalian'
            ]);

            // Buat data di tabel pengembalian dengan status menunggu konfirmasi
            Pengembalian::create([
                'peminjaman_id'   => $peminjaman->id,
                'tanggal_kembali' => Carbon::now(),
                'kondisi'         => $request->kondisi,
                'keterangan'      => $request->keterangan ?? '-',
                'denda'           => 0,
                'status_denda'    => 'pending',
                'status'          => 'menunggu_konfirmasi',
                'metode_bayar'    => null,
            ]);

            // 🔥 Kirim Notif ke Medis
            Notif::create([
                'user_id' => $peminjaman->user_id,
                'judul'   => '📦 Pengembalian Diproses',
                'pesan'   => 'Alat medis yang Anda kembalikan sedang diperiksa oleh petugas. Tunggu update selanjutnya.',
                'is_read' => false
            ]);

            DB::commit();
            return redirect()->route('petugas.pengembalian')
                ->with('success', 'Berhasil! Menunggu konfirmasi akhir petugas.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses: ' . $e->getMessage());
        }
    }

    /**
     * STEP 2: KONFIRMASI AKHIR (Update Stok & Hitung Denda)
     * Dipanggil saat petugas klik tombol 'Konfirmasi' di tabel pengembalian
     */
    public function konfirmasi($id)
    {
        DB::beginTransaction();

        try {
            // Cari data pengembalian
            $pengembalian = Pengembalian::with(['peminjaman.detail.alat', 'peminjaman.user'])
                ->findOrFail($id);

            $peminjaman = $pengembalian->peminjaman;

            if ($peminjaman->status == 'dikembalikan') {
                return back()->with('error', 'Data ini sudah dikonfirmasi sebelumnya.');
            }

            $totalDenda = 0;
            $namaAlatArray = [];

            foreach ($peminjaman->detail as $detail) {
                $alat = $detail->alat;
                if (!$alat) continue;

                $namaAlatArray[] = $alat->nama_alat;

                // 🔄 Kembalikan Stok Alat
                $alat->increment('stok', $detail->qty);

                // 💰 Hitung Denda berdasarkan kondisi yang diinput di STEP 1
                $dendaSatuan = 0;
                $hargaAlat = $alat->harga ?? 0;

                if ($pengembalian->kondisi == 'rusak ringan') {
                    $dendaSatuan = 0.2 * $hargaAlat;
                } elseif ($pengembalian->kondisi == 'rusak berat') {
                    $dendaSatuan = 0.6 * $hargaAlat;
                } elseif ($pengembalian->kondisi == 'hilang') {
                    $dendaSatuan = 1.0 * $hargaAlat;
                }

                $totalDenda += ($dendaSatuan * $detail->qty);
            }

            // Update status final Peminjaman
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => Carbon::now()
            ]);

            // Update status final Pengembalian
            $pengembalian->update([
                'denda' => $totalDenda,
                'status_denda' => $totalDenda > 0 ? 'belum_bayar' : 'lunas',
                'status' => 'dikonfirmasi'
            ]);

            // 🔥 Kirim Notif Detail ke Medis
            $pesan = "Peminjaman #" . $peminjaman->id . " (" . implode(', ', $namaAlatArray) . ") telah diverifikasi.";
            if ($totalDenda > 0) {
                $pesan .= " Anda dikenakan denda Rp " . number_format($totalDenda, 0, ',', '.') . " (Kondisi: " . $pengembalian->kondisi . ").";
            } else {
                $pesan .= " Kondisi alat baik. Terima kasih!";
            }

            Notif::create([
                'user_id' => $peminjaman->user_id,
                'judul'   => '✅ Verifikasi Selesai',
                'pesan'   => $pesan,
                'is_read' => false
            ]);

            DB::commit();
            return back()->with('success', 'Konfirmasi berhasil! Stok telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Konfirmasi gagal: ' . $e->getMessage());
        }
    }

    /**
     * BAYAR DENDA (CASH)
     */
    public function bayarDenda($id)
    {
        try {
            $pengembalian = Pengembalian::with('peminjaman')
                ->where('peminjaman_id', $id)
                ->firstOrFail();

            if ($pengembalian->status_denda == 'lunas') {
                return back()->with('info', 'Denda sudah lunas.');
            }

            $pengembalian->update([
                'status_denda' => 'lunas',
                'metode_bayar' => 'cash',
                'tanggal_bayar' => now(),
            ]);

            // 🔥 Kirim Notif Pembayaran
            Notif::create([
                'user_id' => $pengembalian->peminjaman->user_id,
                'judul'   => '💰 Denda Dilunasi',
                'pesan'   => 'Pembayaran denda untuk transaksi #' . $id . ' telah diterima. Terima kasih.',
                'is_read' => false
            ]);

            return back()->with('success', 'Pembayaran denda berhasil dicatat.');

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran.');
        }
    }
}
