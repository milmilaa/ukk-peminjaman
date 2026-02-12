<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cetak extends Model
{
    use HasFactory;

    protected $table = 'cetak';

    protected $fillable = [
        'jenis',
        'tanggal_mulai',
        'tanggal_selesai',
    ];
}
