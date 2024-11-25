<?php
// database/migrations/xxxx_xx_xx_create_payment_proofs_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentProofsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_proofs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembayaran_id')->constrained('pembayarans')->onDelete('cascade');
            $table->string('file_path');
            $table->enum('status', ['belum_lunas', 'lunas'])->default('belum_lunas');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_proofs');
    }
}

