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
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required']
        ]);

        /**
         * ATTEMPT LOGIN
         */
        if (Auth::attempt($credentials)) {

            // WAJIB regenerate session (security)
            $request->session()->regenerate();

            $user = Auth::user();

            /**
             * CEK STATUS AKUN
             */
            if (!$user || $user->status !== 'active') {
                Auth::logout();
                return back()->with('error', 'Akun Anda tidak aktif');
            }

            /**
             * REDIRECT GLOBAL DASHBOARD
             */
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Email atau password salah');
    }

    /**
     * LOGOUT
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
