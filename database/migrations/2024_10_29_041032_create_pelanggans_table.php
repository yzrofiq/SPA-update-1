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
    Schema::create('pelanggans', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('alamat');
        $table->string('nomor_telepon');
        $table->string('email')->nullable();
        $table->unsignedBigInteger('user_id'); // Add user_id column
        $table->timestamps();

        // Define the foreign key constraint
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggans');
    }
};
