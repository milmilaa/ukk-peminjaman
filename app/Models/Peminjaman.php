<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'alat_id',
        'user_id',
        'status',
        'tanggal_pinjam',
    ];

    public function alat()
{
    return $this->belongsTo(Alat::class, 'alat_id');
}

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
