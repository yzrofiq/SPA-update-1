<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function index()
    {
        // Mengambil data pembayaran dengan relasi tagihan
        $pembayarans = Pembayaran::with('tagihan')->paginate(10);
        return view('pembayarans.index', compact('pembayarans'));
    }

    public function create()
    {
        // Mengambil tagihan yang belum lunas
        $tagihans = Tagihan::where('status', 0)->get();
        return view('pembayarans.create', compact('tagihans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tagihan_id' => 'required|exists:tagihans,id',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        // Mengambil data tagihan terkait
        $tagihan = Tagihan::findOrFail($request->tagihan_id);

        // Cek apakah tagihan sudah lunas
        if ($tagihan->status == 1) {
            return back()->withErrors('Tagihan ini sudah lunas.');
        }

        // Simpan data pembayaran
        Pembayaran::create([
            'user_id' => Auth::id(), // Mengambil user ID yang sedang login
            'tagihan_id' => $request->tagihan_id,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah_bayar' => $request->jumlah_bayar,
        ]);

        // Update status tagihan menjadi lunas
        $tagihan->update(['status' => 1]);

        return redirect()->route('pembayarans.index')->with('success', 'Pembayaran berhasil disimpan.');
    }

    public function edit($id)
    {
        // Mengambil data pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($id);

        // Mengambil semua tagihan yang belum lunas
        $tagihans = Tagihan::where('status', 0)->orWhere('id', $pembayaran->tagihan_id)->get();

        return view('pembayarans.edit', compact('pembayaran', 'tagihans'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tagihan_id' => 'required|exists:tagihans,id',
            'tanggal_pembayaran' => 'required|date',
            'jumlah_bayar' => 'required|numeric|min:0',
        ]);

        // Mengambil data pembayaran terkait
        $pembayaran = Pembayaran::findOrFail($id);
        $tagihan = Tagihan::findOrFail($request->tagihan_id);

        // Update data pembayaran
        $pembayaran->update([
            'tagihan_id' => $request->tagihan_id,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'jumlah_bayar' => $request->jumlah_bayar,
        ]);

        // Update status tagihan menjadi lunas
        $tagihan->update(['status' => 1]);

        return redirect()->route('pembayarans.index')->with('success', 'Pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Mengambil data pembayaran
        $pembayaran = Pembayaran::findOrFail($id);
        $tagihan = $pembayaran->tagihan;

        // Update status tagihan menjadi belum lunas jika pembayaran dihapus
        if ($tagihan) {
            $tagihan->update(['status' => 0]);
        }

        $pembayaran->delete();

        return redirect()->route('pembayarans.index')->with('success', 'Pembayaran berhasil dihapus.');
    }
}
