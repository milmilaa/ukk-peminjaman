<?php

namespace App\Http\Controllers\Medis;

use App\Http\Controllers\Controller;

class AlatController extends Controller
{
    public function index()
    {
        return redirect()->route('medis.dashboard');
    }
}
