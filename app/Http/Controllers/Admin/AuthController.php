<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        // attempt login
        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            $user = auth()->user();

            // ❗ CEK STATUS USER
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->with('error', 'Akun Anda tidak aktif');
            }

            /**
             * JANGAN redirect berdasarkan role di sini
             * Karena SUDAH ADA di route /dashboard
             */
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
