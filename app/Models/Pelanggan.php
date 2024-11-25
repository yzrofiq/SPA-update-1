<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi melalui mass assignment
    protected $fillable = [
        'nama',
        'alamat',
        'nomor_telepon',
        'email',
        'user_id',
    ];

    /**
     * Relasi dengan model Tagihan
     */
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }
}
