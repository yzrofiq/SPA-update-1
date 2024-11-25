<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tagihan; // Import the Tagihan model
use App\Models\Pelanggan; // Import the Pelanggan model

class TagihanController extends Controller
{
    public function index()
    {
        $tagihans = Tagihan::with('pelanggan')->paginate(10); // Paginate results
        return view('tagihans.index', compact('tagihans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::all(); // Retrieve all customers
        return view('tagihans.create', compact('pelanggans'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
            'jumlah_tagihan' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',  // Ensure status is either 0 or 1
        ]);

        // Save tagihan data
        Tagihan::create([
            'pelanggan_id' => $request->pelanggan_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'status' => $request->status,
        ]);

        return redirect()->route('tagihans.index')->with('success', 'Tagihan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $tagihan = Tagihan::findOrFail($id); // Ensuring the tagihan exists
        $pelanggans = Pelanggan::all(); // Retrieve all pelanggan for the dropdown
        return view('tagihans.edit', compact('tagihan', 'pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
            'jumlah_tagihan' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',  // Ensure status is either 0 or 1
        ]);

        $tagihan = Tagihan::findOrFail($id); // Ensure the tagihan exists
        $tagihan->update([
            'pelanggan_id' => $request->pelanggan_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah_tagihan' => $request->jumlah_tagihan,
            'status' => $request->status,  // Update the status here
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
        if ($request->status !== null) {  // Ensure status filter works even for "0"
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
