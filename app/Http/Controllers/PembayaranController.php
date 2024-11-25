<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Pelanggan; // Import the Pelanggan model

class PembayaranController extends Controller
{
    public function index()
    {
        // Retrieve all payments with pagination
        $pembayarans = Pembayaran::paginate(10); // Adjust the number per page as needed
        return view('pembayarans.index', compact('pembayarans'));
    }

    public function create()
    {
        // Retrieve all customers and bills
        $pelanggans = Pelanggan::all(); 
        $tagihans = Tagihan::all(); 
        return view('pembayarans.create', compact('pelanggans', 'tagihans'));
    }
    
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tagihan_id' => 'required|exists:tagihans,id',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_bayar' => 'required|numeric',
        ]);

        // Save payment
        Pembayaran::create([
            'pelanggan_id' => $request->pelanggan_id,
            'tagihan_id' => $request->tagihan_id,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah_bayar' => $request->jumlah_bayar,
        ]);

        // Update the tagihan status to paid
        $tagihan = Tagihan::find($request->tagihan_id);
        $tagihan->status = 1; // Assuming 1 means paid
        $tagihan->save();

        return redirect()->route('pembayarans.index')->with('success', 'Pembayaran berhasil');
    }

    public function edit($id)
    {
        // Find the payment and related tagihan and pelanggan
        $pembayaran = Pembayaran::findOrFail($id);
        $pelanggans = Pelanggan::all(); 
        $tagihans = Tagihan::all();
        return view('pembayarans.edit', compact('pembayaran', 'pelanggans', 'tagihans'));
    }

    public function update(Request $request, $id)
    {
        // Validate request data
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'tagihan_id' => 'required|exists:tagihans,id',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_bayar' => 'required|numeric',
        ]);

        // Find the payment record
        $pembayaran = Pembayaran::findOrFail($id);

        // Update payment details
        $pembayaran->update([
            'pelanggan_id' => $request->pelanggan_id,
            'tagihan_id' => $request->tagihan_id,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah_bayar' => $request->jumlah_bayar,
        ]);

        // Optionally update the tagihan status to paid again, if necessary
        $tagihan = Tagihan::find($request->tagihan_id);
        if ($tagihan) {
            $tagihan->status = 1; // Assuming 1 means paid
            $tagihan->save();
        }

        return redirect()->route('pembayarans.index')->with('success', 'Pembayaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Find the payment record
        $pembayaran = Pembayaran::findOrFail($id);
        
        // Delete the payment
        $pembayaran->delete();

        return redirect()->route('pembayarans.index')->with('success', 'Pembayaran berhasil dihapus');
    }
}
