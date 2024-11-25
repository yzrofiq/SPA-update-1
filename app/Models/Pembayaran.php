<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Pelanggan;

class Pembayaran extends Model
{
    use HasFactory;

    // Menambahkan atribut ke dalam array $fillable
    protected $fillable = [
        'pelanggan_id',    // Pastikan ini ada untuk mass assignment
        'tagihan_id',
        'tanggal_pembayaran',
        'jumlah_bayar',
    ];

    protected $casts = [
        'tanggal_pembayaran' => 'datetime', // Treats 'tanggal_pembayaran' as a Carbon instance
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }
}
