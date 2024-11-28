<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Tambahkan kolom pelanggan_id
            $table->unsignedBigInteger('tagihan_id');
            $table->date('tanggal_pembayaran');
            $table->decimal('jumlah_bayar', 10, 2);
            $table->timestamps();
    
            // Tambahkan foreign key untuk pelanggan_id dan tagihan_id
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tagihan_id')->references('id')->on('tagihans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};

