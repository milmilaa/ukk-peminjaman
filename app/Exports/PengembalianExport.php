<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Maatwebsite\Excel\Concerns\FromCollection;

class PengembalianExport implements FromCollection
{
    public function collection()
    {
        return Pengembalian::with('peminjaman.user', 'peminjaman.alat')->get();
    }
}
