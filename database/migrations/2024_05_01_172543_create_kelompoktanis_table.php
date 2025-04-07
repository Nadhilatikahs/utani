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
        Schema::create('kelompoktanis', function (Blueprint $table) {
            $table->id('id_keltani');
            $table->string('kode_keltani');
            $table->string('nama_keltani');
            $table->string('alamat');
            $table->string('jenis_kelamin');
            $table->string('latitude');
            $table->string('longitude');
            $table->bigInteger('id_desa')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompoktanis');
    }
};
