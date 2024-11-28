<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagihans', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PRIMARY KEY
            $table->unsignedBigInteger('user_id'); // Foreign key ke tabel users
            $table->integer('bulan');
            $table->integer('tahun');
            $table->decimal('jumlah_tagihan', 10, 2);
            $table->boolean('status')->default(0); // 0: belum bayar, 1: sudah bayar
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
