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
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pelanggan_id');
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('jumlah_tagihan', 10, 2);
            $table->boolean('status')->default(0); // 0: belum bayar, 1: sudah bayar
            $table->timestamps();
    
            $table->foreign('pelanggan_id')->references('id')->on('pelanggans')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihans');
    }
};
