<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pelanggan;
use App\Models\Tagihan;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        Pelanggan::create([
            'nama' => 'John Doe',
            'alamat' => 'Jalan Merdeka No. 1',
            'nomor_telepon' => '081234567890',
        ]);
    
        Tagihan::create([
            'pelanggan_id' => 1,
            'bulan' => 1, // Ganti 'Januari' dengan 1 jika Januari
            'tahun' => 2024,
            'jumlah_tagihan' => 50000,
            'status' => 0,
        ]);
        
    }
}
