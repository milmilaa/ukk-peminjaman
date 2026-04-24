<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notif extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'notifs';

    /**
     * Mass Assignable attributes.
     * Kolom-kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'judul',
        'pesan',
        'is_read',
    ];

    /**
     * Casting attributes.
     * Mengubah format data secara otomatis saat dipanggil.
     */
    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Relasi ke model User.
     * Satu notifikasi dimiliki oleh satu User (Penerima).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope untuk mengambil notifikasi yang belum dibaca saja.
     * Contoh penggunaan: Notif::unread()->get();
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
