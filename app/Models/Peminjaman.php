<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'alat_id',
        'user_id',
        'stok',
        'status',
        'tanggal_pinjam',
        'tanggal_kembali',
    ];

    // ================= RELASI =================

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function detail()
    {
        return $this->hasMany(\App\Models\DetailPeminjaman::class, 'peminjaman_id');
    }

    public function pengembalian()
    {
        return $this->hasOne(\App\Models\Pengembalian::class, 'peminjaman_id');
    }
}
