<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;

class UserTagihanController extends Controller
{
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = auth()->user();

        // Ambil semua tagihan milik pengguna
        $tagihans = Tagihan::where('user_id', $user->id)->get();

        // Kirim data ke view
        return view('user.tagihan.index', compact('tagihans'));
    }

    public function show($id)
    {
        // Ambil data pengguna yang sedang login
        $user = auth()->user();

        // Ambil tagihan spesifik berdasarkan ID dan user ID
        $tagihan = Tagihan::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Kirim data ke view
        return view('user.tagihan.show', compact('tagihan'));
    }
}
