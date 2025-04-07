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
        Schema::create('dinas', function (Blueprint $table) {

            $table->id('id_dinas');
            $table->string('kode_dinas');
            $table->string('nama_dinas');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->bigInteger('id_kabupaten')->unsigned();
            $table->timestamps();
        });
    }
   
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dinas');
    }
};
