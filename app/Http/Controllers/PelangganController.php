<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query
        $query = Pelanggan::query();

        // Filter by search query if present
        if ($request->has('search')) {
            $search = $request->query('search');
            $query->where('nama', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%")
                  ->orWhere('nomor_telepon', 'like', "%$search%");
        }

        // Paginate the results
        $pelanggans = $query->paginate(10);

        // Pass $pelanggans to the view
        return view('pelanggan.index', compact('pelanggans'));
    }

    public function show($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $tagihans = $pelanggan->tagihans;
        return view('pelanggan.show', compact('pelanggan', 'tagihans'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

  public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'nomor_telepon' => 'required|string|max:20',
    ]);

    // Add the authenticated user's ID
    Pelanggan::create([
        'nama' => $request->input('nama'),
        'alamat' => $request->input('alamat'),
        'nomor_telepon' => $request->input('nomor_telepon'),
        'user_id' => auth()->id(), // Add the logged-in user's ID
    ]);

    return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil ditambahkan');
}


    public function edit($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'nomor_telepon' => 'required|string|max:20',
        ]);

        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->update($request->all());
        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil diupdate');
    }

    public function destroy($id)
    {
        $pelanggan = Pelanggan::findOrFail($id);
        $pelanggan->delete();
        return redirect()->route('pelanggans.index')->with('success', 'Pelanggan berhasil dihapus');
    }

    // Export pelanggan data to CSV
    public function exportCSV()
    {
        $fileName = 'data_pelanggan.csv';
        $pelanggans = Pelanggan::all();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Nama', 'Alamat', 'Nomor Telepon'];

        $callback = function() use ($pelanggans, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($pelanggans as $pelanggan) {
                fputcsv($file, [$pelanggan->nama, $pelanggan->alamat, $pelanggan->nomor_telepon]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Filter pelanggan by address
    public function filterByAddress(Request $request)
    {
        $address = $request->query('address');
        $pelanggans = Pelanggan::where('alamat', 'like', "%$address%")->paginate(10);
        
        return view('pelanggan.index', compact('pelanggans'))->with('info', "Filter berdasarkan alamat: $address");
    }

    // Sort pelanggan by name
    public function sortByName($order = 'asc')
    {
        $pelanggans = Pelanggan::orderBy('nama', $order)->paginate(10);

        return view('pelanggan.index', compact('pelanggans'))->with('info', "Diurutkan berdasarkan nama secara " . ($order == 'asc' ? 'ascending' : 'descending'));
    }


    public function showProof($id)
    {
        // Fetch the payment with the provided ID
        $pembayaran = Pembayaran::findOrFail($id);

        // Assuming paymentProof is a related model (hasOne or hasMany)
        $paymentProof = $pembayaran->paymentProof;  // Adjust this if necessary

        return view('pembayarans.proof', compact('paymentProof'));
    }

}
