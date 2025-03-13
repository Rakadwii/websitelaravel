<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // Cegah akses login bagi user yang sudah login
        $this->middleware('auth')->only('logout'); // Pastikan hanya user yang login bisa logout
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string', 
            'password' => 'required|string|min:6',
        ]);

        // Cek apakah username berupa email atau hanya username
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $login = [
            $loginType => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($login)) {
            $request->session()->regenerate(); // Hindari session hijacking
            return redirect()->intended('/dashboard'); // Ubah jika ingin ke halaman lain
        }

        return back()->withInput()->withErrors(['username' => 'Email/Password salah!']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login'); // Pastikan ada rute /login
    }
}
