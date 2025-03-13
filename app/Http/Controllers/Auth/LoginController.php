<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Pastikan ini ada
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller // Pastikan ini mewarisi Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string', 
            'password' => 'required|string|min:6',
        ]);

        // Cek apakah input username adalah email atau hanya username
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // Data untuk proses login
        $login = [
            $loginType => $request->username,
            'password' => $request->password
        ];

        // Coba lakukan login
        if (Auth::attempt($login)) { 
            return redirect()->intended('/home');
        }

        // Jika gagal login, kembali ke halaman login dengan pesan error
        return back()->withInput()->withErrors(['username' => 'Email/Password salah!']);
    }
}
