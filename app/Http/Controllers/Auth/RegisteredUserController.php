<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DetailProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input dari form registrasi
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:detail_profile'], // Menggunakan tabel detail_profile
            'email' => ['required', 'string', 'email', 'max:255', 'unique:detail_profile'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            //'address' => ['required', 'string', 'max:255'], // Tambahkan validasi address
            //'nomor_telp' => ['required', 'string', 'max:15'], // Tambahkan validasi nomor telepon
            //'ttl' => ['required', 'date'], // Tambahkan validasi TTL
        ]);

        // Simpan user ke database
        $detail_profile = DetailProfile::create([
            'nama' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            //'address' => $request->address,
            //'nomor_telp' => $request->nomor_telp,
            //'ttl' => $request->ttl,
        ]);

        // Trigger event pendaftaran
        event(new Registered($detail_profile));

        // Login user setelah registrasi
        Auth::login($detail_profile);

        return redirect()->route('login');
    }
}
