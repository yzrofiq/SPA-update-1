<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBuktiPembayaranToPembayaransTable extends Migration
{
    public function up()
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->string('bukti_pembayaran')->nullable();  // Store image path
        });
    }

    public function down()
    {
        Schema::table('pembayarans', function (Blueprint $table) {
            $table->dropColumn('bukti_pembayaran');
        });
    }
}
