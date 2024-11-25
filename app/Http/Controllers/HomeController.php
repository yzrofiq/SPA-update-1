<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan; // Correctly import the Pelanggan model
use App\Models\Tagihan;
use App\Models\Pembayaran;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth'); // Ensure the user is authenticated
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch data for the admin dashboard
        $pelanggans = Pelanggan::all(); // Get all customers
        $tagihans = Tagihan::all(); // Get all invoices
        $pembayarans = Pembayaran::all(); // Get all payments

        // You can also add specific data like counts or filtered data
        $totalPelanggans = Pelanggan::count(); // Count of all customers
        $totalTagihans = Tagihan::count(); // Count of all invoices
        $totalPembayarans = Pembayaran::count(); // Count of all payments
        $totalPembayaran = Pembayaran::sum('jumlah_bayar'); // Total payment amount (adjust based on your schema)

        // Passing data to the view
        return view('home', compact('pelanggans', 'tagihans', 'pembayarans', 'totalPelanggans', 'totalTagihans', 'totalPembayarans', 'totalPembayaran'));

    }
}
