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
        Schema::create('bpps', function (Blueprint $table) {
            $table->id('id_bpp');
            $table->string('kode_bpp');
            $table->string('nama_bpp');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->bigInteger('id_upt')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bpps');
    }
};
