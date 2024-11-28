<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Tampilkan dashboard pengguna.
     *
     * @return \Illuminate\View\View
     */
    public function index()
{
    // Get the logged-in user's ID
    $userId = Auth::id(); // This will get the currently authenticated user's ID

    // Fetch tagihan and pembayaran data using 'user_id'
    $tagihans = Tagihan::where('user_id', $userId)->get();
    $pembayarans = Pembayaran::where('user_id', $userId)->get();

    // Return the view with the processed data
    return view('user.dashboard', compact('tagihans', 'pembayarans'));
}

}
