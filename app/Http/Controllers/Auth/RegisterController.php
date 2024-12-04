<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:15',
        ]);

        // Simpan user ke database (tabel users)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Simpan data pelanggan ke database (tabel pelanggan)
        Pelanggan::create([
            'nama' => $request->name,
            'alamat' => $request->alamat,
            'nomor_telepon' => $request->nomor_telepon,
            'email' => $request->email,
            'user_id' => $user->id, // Relasi dengan tabel users
        ]);

        // Login user setelah registrasi berhasil
        Auth::login($user);

        // Redirect ke halaman utama (atau sesuai rute yang diinginkan)
        event(new Registered($user));

    // Redirect ke halaman pemberitahuan
    return redirect()->route('verification.notice');
    }
}
