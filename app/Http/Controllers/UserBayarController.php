<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Midtrans\Config;
use Midtrans\Snap;

class UserBayarController extends Controller
{
    public function index()
    {
      
        // Ambil semua pembayaran milik pengguna
        $pembayarans = Pembayaran::where('user_id', auth()->id())->get();
        
        return view('user.pembayarans.index', compact('pembayarans'));

        
    }
    public function create($tagihanId)
    {
        $user = auth()->user();
    
        // Ambil tagihan pengguna
        $tagihan = Tagihan::where('id', $tagihanId)
            ->where('user_id', $user->id)
            ->firstOrFail();
    
        if ($tagihan->status == 1) {
            return redirect()->route('user.tagihan.index')->with('error', 'Tagihan sudah lunas.');
        }
    
        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    
        // Parameter Snap Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => 'INV-' . uniqid(),
                'gross_amount' => $tagihan->jumlah_tagihan,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '081234567890',
            ],
        ];
    
        try {
            // Dapatkan Snap Token dari Midtrans
            $snapToken = Snap::getSnapToken($params);
    
            // Return ke view pembayaran
            return view('user.payment.snap', compact('snapToken', 'tagihan'));
        } catch (\Exception $e) {
            return redirect()->route('user.tagihan.index')
                ->with('error', 'Gagal membuat token pembayaran: ' . $e->getMessage());
        }
    }
    
    public function updateStatus(Request $request, $id)
{
    // Validasi request
    $request->validate([
        'status' => 'required|in:0,1', // 0 untuk belum lunas, 1 untuk lunas
    ]);

    // Ambil data pengguna
    $user = auth()->user();

    // Cari tagihan milik pengguna berdasarkan ID
    $tagihan = Tagihan::where('id', $id)
        ->where('user_id', $user->id)
        ->firstOrFail();

    // Perbarui status tagihan
    $tagihan->status = $request->status;
    $tagihan->save();

    return response()->json(['message' => 'Status tagihan berhasil diperbarui.']);
}


    public function storePayment(Request $request, $tagihanId)
    {
        // Validasi input
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        // Ambil data pengguna
        $user = auth()->user();

        // Cari tagihan
        $tagihan = Tagihan::where('id', $tagihanId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Periksa apakah tagihan sudah lunas
        if ($tagihan->status == 1) {
            return redirect()->route('user.tagihan.index')->with('error', 'Tagihan sudah lunas.');
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
        return redirect()->route('user.tagihan.index')->with('success', 'Pembayaran berhasil dilakukan!');
    }
    
    
}
