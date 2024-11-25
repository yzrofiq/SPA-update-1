<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    public function index()
    {
        // Fetch the authenticated user
        $user = auth()->user();
        
        // Fetch tagihan (bills) and pembayaran (payments) related to the user
        $tagihans = Tagihan::where('user_id', $user->id)->get();
        $pembayarans = Pembayaran::where('user_id', $user->id)->get();

        // Pass the data to the view
        return view('user.dashboard', compact('tagihans', 'pembayarans'));
    }

    // Add a new method for handling the "bayar" (payment) action
    public function createPayment($tagihanId)
    {
        // Fetch the authenticated user
        $user = auth()->user();

        // Fetch the tagihan (bill) based on the provided tagihan ID
        $tagihan = Tagihan::where('id', $tagihanId)->where('user_id', $user->id)->firstOrFail();

        // Pass the data to the view where the user can pay
        return view('user.payment.create', compact('tagihan'));
    }

    // Add a method to handle the payment submission (optional if you want to process payments)
    public function storePayment(Request $request, $tagihanId)
    {
        // Fetch the authenticated user
        $user = auth()->user();

        // Validate the payment request
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string', // Assuming payment method is required
        ]);

        // Fetch the tagihan (bill)
        $tagihan = Tagihan::where('id', $tagihanId)->where('user_id', $user->id)->firstOrFail();

        // Check if the payment is for the correct tagihan (e.g., not paid yet)
        if ($tagihan->status == 1) {
            return redirect()->route('user.dashboard')->with('error', 'Tagihan sudah lunas!');
        }

        // Create the payment record
        Pembayaran::create([
            'user_id' => $user->id,
            'tagihan_id' => $tagihan->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending', // Assuming pending until confirmed
        ]);

        // Update the tagihan status to "paid"
        $tagihan->status = 1; // Mark the bill as paid
        $tagihan->save();

        // Redirect the user to their dashboard with success message
        return redirect()->route('user.dashboard')->with('success', 'Pembayaran berhasil dilakukan!');
    }
}
