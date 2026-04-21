<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'foto',
        'role',
        'status',
    ];

    /**
     * Tambahkan keterangan ke JSON (opsional tapi bagus)
     */
    protected $appends = ['keterangan'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * 🔥 KETERANGAN OTOMATIS BERDASARKAN ROLE
     */
    public function getKeteranganAttribute()
    {
        return match($this->role) {
            'admin'   => 'IT / Pengelola Sistem',
            'petugas' => 'Gudang Alat',
            'medis'   => 'Tenaga Medis',
            default   => '-',
        };
    }
}
