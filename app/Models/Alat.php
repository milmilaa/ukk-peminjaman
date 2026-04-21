<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    // ✅ sesuaikan dengan nama tabel di database
    protected $table = 'alats';

    protected $fillable = [
        'nama_alat',
        'kategori_id',
        'jumlah',
        'gambar'
    ];

    // relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // relasi ke peminjaman
    public function peminjaman()
{
    return $this->hasMany(Peminjaman::class, 'alat_id');
}

    public function detailPeminjaman()
{
    return $this->hasMany(DetailPeminjaman::class, 'alat_id');
}
}
