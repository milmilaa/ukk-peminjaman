<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Alat Diagnostik',
            'Alat Bedah',
            'Alat Monitoring',
            'Alat Terapi',
            'Alat Rehabilitasi',
            'Alat Perawatan Pasien',
            'Peralatan Laboratorium',
            'Peralatan Radiologi',
            'Peralatan Gawat Darurat',
            'Peralatan ICU',
            'Peralatan Kebidanan',
            'Peralatan Sterilisasi',
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create([
                'nama' => $kategori
            ]);
        }
    }
}
