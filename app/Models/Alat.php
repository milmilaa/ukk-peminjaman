<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_alat',
        'kategori_id',
        'jumlah',
        'gambar'
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}
