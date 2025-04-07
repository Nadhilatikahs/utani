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
        Schema::create('upts', function (Blueprint $table) {
            $table->id('id_upt');
            $table->string('kode_upt')->unique();
            $table->string('nama_upt')->unique();
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->bigInteger('id_dinas')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upts');
    }
};
