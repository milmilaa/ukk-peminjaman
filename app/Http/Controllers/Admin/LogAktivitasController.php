<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LogAktivitasController extends Controller
{
    public function index()
    {
        return view('admin.log');
    }
}
