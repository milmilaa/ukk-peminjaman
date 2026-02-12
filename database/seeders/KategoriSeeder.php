<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Elektronik',
            'Alat Tulis & Kantor',
            'Olahraga',
            'Seni & Musik',
            'Infrastruktur Teknologi',
            'Barang Praktik Kejuruan',
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama' => $kategori
            ]);
        }
    }
}
