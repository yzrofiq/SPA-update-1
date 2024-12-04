<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Ambil data pengguna yang sedang login
        $user = auth()->user();
        
        // Ambil daftar tagihan dan pembayaran milik pengguna
        $tagihans = Tagihan::where('user_id', $user->id)->get();
        $pembayarans = Pembayaran::where('user_id', $user->id)->get();

        // Kirim data ke view dashboard
        return view('user.dashboard', compact('tagihans', 'pembayarans'));
    }

    public function createPayment($tagihanId)
    {
        // Ambil data pengguna
        $user = auth()->user();

        // Cari tagihan berdasarkan ID dan user ID
        $tagihan = Tagihan::where('id', $tagihanId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Kirim data ke halaman pembayaran
        return view('user.payment.create', compact('tagihan'));
    }

    public function storePayment(Request $request, $tagihanId)
    {
        // Validasi input
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string', // Metode pembayaran
        ]);

        // Ambil data pengguna
        $user = auth()->user();

        // Cari tagihan yang sesuai
        $tagihan = Tagihan::where('id', $tagihanId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Periksa apakah tagihan sudah lunas
        if ($tagihan->status == 1) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Tagihan sudah lunas!');
        }

        // Simpan data pembayaran
        Pembayaran::create([
            'user_id' => $user->id,
            'tagihan_id' => $tagihan->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'completed', // Tandai pembayaran selesai
        ]);

        // Perbarui status tagihan menjadi lunas
        $tagihan->status = 1;
        $tagihan->save();

        // Redirect dengan pesan sukses
        return redirect()->route('user.dashboard')
            ->with('success', 'Pembayaran berhasil dilakukan!');
    }
}
