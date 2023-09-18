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
        Schema::create('logtaprfids', function (Blueprint $table) {
            $table->id();
            $table->string('rfiddata');
            $table->string('username')->nullable();
            $table->string('keterangan'); // masuk atau keluar
            $table->boolean('respon'); // jika tidak ada data di database maka respon = false

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logtaprfids');
    }
};
