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
            $table->bigIncrements('id_provinsi');
            $table->string('kode_provinsi');
            $table->string('nama_provinsi');
            $table->string('latitude');
            $table->string('longitude');
            $table->timestamps();
        });

        // KABUPATEN
        Schema::create('kabupatens', function (Blueprint $table) {
            $table->bigIncrements('id_kabupaten');
            $table->string('kode_kabupaten');
            $table->string('nama_kabupaten');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignId('id_provinsi')
                ->constrained('provinsis')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        // DINAS
        Schema::create('dinas', function (Blueprint $table) {
            $table->bigIncrements('id_dinas');
            $table->string('kode_dinas');
            $table->string('nama_dinas');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignId('id_kabupaten')
                ->constrained('kabupatens', 'id_kabupaten')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        // UPT
        Schema::create('upts', function (Blueprint $table) {
            $table->bigIncrements('id_upt');
            $table->string('kode_upt');
            $table->string('nama_upt');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignId('id_dinas')
                ->constrained('dinas', 'id_dinas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        // BPP
        Schema::create('bpps', function (Blueprint $table) {
            $table->bigIncrements('id_bpp');
            $table->string('kode_bpp');
            $table->string('nama_bpp');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignId('id_upt')
                ->constrained('upts', 'id_upt')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        // DESA
        Schema::create('desas', function (Blueprint $table) {
            $table->bigIncrements('id_desa');
            $table->string('kode_desa');
            $table->string('nama_desa');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignId('id_bpp')
                ->constrained('bpps', 'id_bpp')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();
        });

        // G I S (titik lokasi umum)
        Schema::create('gis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->timestamps();
        });

        // VIEW sederhana waktu (dipakai di laporan / filter)
        Schema::create('v_waktu', function (Blueprint $table) {
            $table->string('waktu', 7)->primary(); // contoh: '2025-01'
        });

        Schema::create('v_waktu_parameter', function (Blueprint $table) {
            $table->string('waktu', 2)->primary(); // contoh: '01', '02', ...
        });

        // Pemetaan hasil tani (ditambahkan id sebagai PK)
        Schema::create('pemetaan_hasiltani', function (Blueprint $table) {
            $table->increments('id');
            $table->string('longitude', 100);
            $table->string('latitude', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemetaan_hasiltani');
        Schema::dropIfExists('v_waktu_parameter');
        Schema::dropIfExists('v_waktu');
        Schema::dropIfExists('gis');
        Schema::dropIfExists('desas');
        Schema::dropIfExists('bpps');
        Schema::dropIfExists('upts');
        Schema::dropIfExists('dinas');
        Schema::dropIfExists('kabupatens');
        Schema::dropIfExists('provinsis');
    }
};
