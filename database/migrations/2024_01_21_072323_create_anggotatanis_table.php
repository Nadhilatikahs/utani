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
        Schema::create('anggotatanis', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->string('kode_anggota');
            $table->string('nama_anggota');
            $table->string('nik');
            $table->string('tempat_lahir');
            $table->string('alamat');              // ✅ cukup sekali
            $table->string('jenis_kelamin');
            $table->string('no_hp', 20);           // ✅ ganti int() -> string()
            $table->string('status_anggota');
            $table->string('kategori_petani');
            $table->string('latitude');
            $table->string('longitude');
            $table->bigInteger('id_keltani')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anggotatanis');
    }
};
