<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

class NotifController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Peminjaman::with(['user']);

        // ======================
        // FILTER ROLE (OPTIONAL)
        // ======================
        if ($request->role == 'admin') {
            $query->whereHas('user', function ($q) {
                $q->where('role', 'admin');
            });
        }

        if ($request->role == 'petugas') {
            $query->whereHas('user', function ($q) {
                $q->where('role', 'petugas');
            });
        }

        // ======================
        // ROLE LOGIC UTAMA
        // ======================
        if ($user->role == 'medis') {
            $query->where('user_id', $user->id);
        }

        if ($user->role == 'petugas') {
            $query->whereIn('status', ['menunggu', 'dipinjam', 'ditolak']);
        }

        $data = $query->latest()->get();

        return view('notif.index', compact('data'));
    }
}
