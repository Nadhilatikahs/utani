<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // KELOMPOK TANI
        Schema::create('kelompoktanis', function (Blueprint $table) {
            $table->id('id_keltani');
            $table->string('kode_keltani');
            $table->string('nama_keltani');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->unsignedBigInteger('id_desa');
            $table->timestamps();

            $table->foreign('id_desa')
                ->references('id_desa')
                ->on('desas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // ANGGOTA TANI
        Schema::create('anggotatanis', function (Blueprint $table) {
            $table->id('id_anggota');
            $table->string('kode_anggota');
            $table->string('nama_anggota');
            $table->string('nik')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('alamat');
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('no_hp')->nullable();
            $table->string('status_anggota')->nullable();
            $table->string('kategori_petani')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->unsignedBigInteger('id_keltani');
            $table->timestamps();

            $table->foreign('id_keltani')
                ->references('id_keltani')
                ->on('kelompoktanis')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // LAHAN
        Schema::create('lahans', function (Blueprint $table) {
            $table->id('id_lahan');
            $table->string('kode_lahan');
            $table->unsignedBigInteger('id_anggota');
            $table->decimal('luas', 10, 2)->default(0);
            $table->integer('jml_petak')->default(0);
            $table->timestamps();

            $table->foreign('id_anggota')
                ->references('id_anggota')
                ->on('anggotatanis')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // KOMODITAS
        Schema::create('komoditas', function (Blueprint $table) {
            $table->id('id_komoditas');
            $table->string('kode_komoditas');
            $table->string('nama_komoditas');
            $table->string('kategori')->nullable();
            $table->decimal('harga_satuan', 14, 2)->default(0);
            $table->timestamps();
        });

        // KATEGORI BEBAN
        Schema::create('kategori', function (Blueprint $table) {
            $table->id('id_kategori');
            $table->string('kode_kategori');
            $table->string('keterangan');
            $table->timestamps();
        });

        // BEBAN
        Schema::create('bebans', function (Blueprint $table) {
            $table->id('id_beban');
            $table->string('kode_beban');
            $table->string('nama_beban');
            $table->string('kategori')->nullable(); // tetap / variabel
            $table->unsignedBigInteger('id_kategori')->nullable();
            $table->timestamps();

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });

        // TANAM
        Schema::create('tanams', function (Blueprint $table) {
            $table->id('id_tanam');
            $table->string('kode_tanam', 15);
            $table->unsignedBigInteger('id_lahan');
            $table->unsignedBigInteger('id_komoditas');
            $table->date('tgl_tanam');
            $table->date('tgl_panen')->nullable();
            $table->decimal('volume_panen', 14, 2)->nullable();
            $table->decimal('beban_variabel', 14, 2)->nullable();
            $table->decimal('beban_fix', 14, 2)->nullable();
            $table->decimal('keuntungan', 14, 2)->nullable();
            $table->timestamps();

            $table->foreign('id_lahan')
                ->references('id_lahan')
                ->on('lahans')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_komoditas')
                ->references('id_komoditas')
                ->on('komoditas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // BEBAN TANAM (DETAIL BIAYA PRODUKSI)
        Schema::create('bebantanam', function (Blueprint $table) {
            $table->id('id_bebantanam');
            $table->string('kode_bebantanam', 50);
            $table->unsignedBigInteger('id_tanam');
            $table->unsignedBigInteger('id_beban');
            $table->string('satuan', 11);
            $table->decimal('jumlah', 14, 2);
            $table->decimal('harga', 14, 2);
            $table->decimal('total', 14, 2)->nullable();
            $table->timestamps();

            $table->foreign('id_tanam')
                ->references('id_tanam')
                ->on('tanams')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('id_beban')
                ->references('id_beban')
                ->on('bebans')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // PANEN
        Schema::create('panens', function (Blueprint $table) {
            $table->id('id_panen');
            $table->string('kode_panen', 50);
            $table->unsignedBigInteger('id_tanam');
            $table->date('tgal_panen');
            $table->decimal('jumlah', 14, 2);
            $table->decimal('harga', 14, 2);
            $table->decimal('hasil_panen', 14, 2)->nullable();
            $table->timestamps();

            $table->foreign('id_tanam')
                ->references('id_tanam')
                ->on('tanams')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panens');
        Schema::dropIfExists('bebantanam');
        Schema::dropIfExists('tanams');
        Schema::dropIfExists('bebans');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('komoditas');
        Schema::dropIfExists('lahans');
        Schema::dropIfExists('anggotatanis');
        Schema::dropIfExists('kelompoktanis');
    }
};
