<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Alat;

class AlatController extends Controller
{
    public function index()
    {
        $alat = Alat::where('stok','>',0)->get();

        return view('siswa.alat', compact('alat'));
    }
}
