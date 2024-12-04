<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan;
use App\Models\Pelanggan;

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::with('pelanggan')->paginate(10); // Paginate results
        return view('tagihans.index', compact('tagihans'));

        
    }

    public function create()
    {
        // Ambil data pelanggan
        $pelanggans = Pelanggan::all();
        
        // Tampilkan form tambah tagihan
        return view('tagihans.create', compact('pelanggans'));
    }
    public function edit($id)
    {
        // Temukan tagihan berdasarkan ID
        $tagihan = Tagihan::findOrFail($id);

        // Ambil data pelanggan untuk dropdown
        $pelanggans = Pelanggan::all();

        return view('tagihans.edit', compact('tagihan', 'pelanggans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
            'jumlah_tagihan' => 'required|numeric|min:0',
            'status' => 'required|in:0,1', // Ensure status is either 0 or 1
        ]);

        // Ambil user_id berdasarkan pelanggan yang dipilih
        $pelanggan = Pelanggan::findOrFail($request->pelanggan_id);
        $userId = $pelanggan->user_id;

        // Simpan data tagihan
        Tagihan::create([
            'pelanggan_id' => $request->pelanggan_id,
            'user_id' => $userId, // Ambil user_id dari pelanggan
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'status' => $request->status,
        ]);

        return redirect()->route('tagihans.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id', // Validasi pelanggan_id
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
            'jumlah_tagihan' => 'required|numeric|min:0',
            'status' => 'required|in:0,1', // Ensure status is either 0 or 1
        ]);

        $tagihan = Tagihan::findOrFail($id); // Pastikan tagihan ada

        // Ambil user_id dari pelanggan yang dipilih
        $pelanggan = Pelanggan::findOrFail($request->pelanggan_id);
        $userId = $pelanggan->user_id;

        // Update data tagihan
        $tagihan->update([
            'pelanggan_id' => $request->pelanggan_id,
            'user_id' => $userId, // Perbarui user_id
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'status' => $request->status, // Update the status here
        ]);

        return redirect()->route('tagihans.index')->with('success', 'Tagihan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tagihan = Tagihan::findOrFail($id); // Ensure the tagihan exists
        $tagihan->delete();

        return redirect()->route('tagihans.index')->with('success', 'Tagihan berhasil dihapus.');
    }

    public function laporan(Request $request)
    {
        $query = Tagihan::query();

        if ($request->bulan) {
            $query->where('bulan', $request->bulan);
        }
        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->status !== null) { // Ensure status filter works even for "0"
            $query->where('status', $request->status);
        }

        $tagihans = $query->with('pelanggan')->get(); // Include pelanggan relation for report view

        return view('tagihans.laporan', compact('tagihans'));
    }

    public function updateStatus($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $tagihan->status = 1; // Set status to "lunas"
        $tagihan->save();

        return redirect()->route('tagihans.index')->with('success', 'Tagihan berhasil ditandai lunas');
    }
    
}
