<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tagihans', function (Blueprint $table) {
            $table->boolean('status')->default(0)->change(); // Modify the default value if needed
        });
    }
    
};
