<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    use HasFactory;

    // Specify which fields can be mass assigned
    protected $fillable = [
        'user_id',  // Add this field to allow mass assignment
        'bulan',
        'tahun',
        'jumlah_tagihan',
        'status',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function pembayaran()
{
    return $this->hasMany(Pembayaran::class);
}


    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
