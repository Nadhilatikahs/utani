<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PROVINSI
        Schema::create('provinsis', function (Blueprint $table) {
            $table->id('id_provinsi');
            $table->string('kode_provinsi');
            $table->string('nama_provinsi');
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
        });

        // KABUPATEN
        Schema::create('kabupatens', function (Blueprint $table) {
            $table->id('id_kabupaten');
            $table->string('kode_kabupaten');
            $table->string('nama_kabupaten');
            $table->string('latitude');
            $table->string('longitude');

            $table->unsignedBigInteger('id_provinsi');
            $table->timestamps();

            $table->foreign('id_provinsi')
                ->references('id_provinsi')
                ->on('provinsis')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // DINAS
        Schema::create('dinas', function (Blueprint $table) {
            $table->id('id_dinas');
            $table->string('kode_dinas');
            $table->string('nama_dinas');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('id_kabupaten');
            $table->timestamps();

            $table->foreign('id_kabupaten')
                ->references('id_kabupaten')
                ->on('kabupatens')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // UPT
        Schema::create('upts', function (Blueprint $table) {
            $table->id('id_upt');
            $table->string('kode_upt');
            $table->string('nama_upt');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('id_dinas');
            $table->timestamps();

            $table->foreign('id_dinas')
                ->references('id_dinas')
                ->on('dinas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // BPP
        Schema::create('bpps', function (Blueprint $table) {
            $table->id('id_bpp');
            $table->string('kode_bpp');
            $table->string('nama_bpp');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('id_upt');
            $table->timestamps();

            $table->foreign('id_upt')
                ->references('id_upt')
                ->on('upts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // DESA
        Schema::create('desas', function (Blueprint $table) {
            $table->id('id_desa');
            $table->string('kode_desa');
            $table->string('nama_desa');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('id_bpp');
            $table->timestamps();

            $table->foreign('id_bpp')
                ->references('id_bpp')
                ->on('bpps')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desas');
        Schema::dropIfExists('bpps');
        Schema::dropIfExists('upts');
        Schema::dropIfExists('dinas');
        Schema::dropIfExists('kabupatens');
        Schema::dropIfExists('provinsis');
    }
};
