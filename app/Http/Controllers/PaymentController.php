<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Method to show the payment form
    public function create($tagihanId)
    {
        // Fetch the tagihan (bill) by ID
        $tagihan = Tagihan::findOrFail($tagihanId);

        // Return the payment view with the tagihan details
        return view('user.payment.create', compact('tagihan'));
    }

    // Method to store the payment
    public function store(Request $request, $tagihanId)
    {
        // Fetch the tagihan by ID
        $tagihan = Tagihan::findOrFail($tagihanId);

        // Store the payment
        $pembayaran = new \App\Models\Pembayaran();
        $pembayaran->user_id = auth()->id();
        $pembayaran->tagihan_id = $tagihan->id;
        $pembayaran->jumlah_bayar = $request->jumlah_bayar;
        $pembayaran->tanggal_pembayaran = now();
        $pembayaran->save();

        // If the payment is equal or greater than the tagihan amount, mark it as "Lunas"
        if ($pembayaran->jumlah_bayar >= $tagihan->jumlah_tagihan) {
            $tagihan->status = 1; // Mark as 'Lunas'
            $tagihan->save();
        }

        // Redirect to the dashboard or success page
        return redirect()->route('user.dashboard')->with('success', 'Pembayaran berhasil dilakukan.');
    }
}

