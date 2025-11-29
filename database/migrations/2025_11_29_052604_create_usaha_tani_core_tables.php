<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * KELOMPOK TANI
         */
        Schema::create('kelompoktanis', function (Blueprint $table) {
            $table->bigIncrements('id_keltani');
            $table->string('kode_keltani');
            $table->string('nama_keltani');
            $table->string('alamat');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignId('id_desa')
                ->constrained('desas', 'id_desa')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique('kode_keltani');
        });

        /**
         * ANGGOTA TANI
         */
        Schema::create('anggotatanis', function (Blueprint $table) {
            $table->bigIncrements('id_anggota');
            $table->string('kode_anggota');
            $table->string('nama_anggota');
            $table->string('nik');
            $table->string('tempat_lahir');
            $table->string('alamat');
            $table->string('jenis_kelamin');
            $table->string('no_hp', 12);
            $table->string('status_anggota');
            $table->string('kategori_petani');
            $table->string('latitude');
            $table->string('longitude');
            $table->foreignId('id_keltani')
                ->constrained('kelompoktanis', 'id_keltani')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique('kode_anggota');
        });

        /**
         * LAHAN
         */
        Schema::create('lahans', function (Blueprint $table) {
            $table->bigIncrements('id_lahan');
            $table->string('kode_lahan', 25);
            $table->foreignId('id_anggota')
                ->constrained('anggotatanis', 'id_anggota')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->float('luas', 10, 0);
            $table->integer('jml_petak');
            $table->timestamps();

            $table->unique('kode_lahan');
        });

        /**
         * KOMODITAS
         */
        Schema::create('komoditas', function (Blueprint $table) {
            $table->bigIncrements('id_komoditas');
            $table->string('kode_komoditas', 25);
            $table->string('nama_komoditas');
            $table->string('kategori');
            // Perbaikan: harga_satuan pakai decimal untuk uang
            $table->decimal('harga_satuan', 15, 2);
            $table->timestamps();

            $table->unique('kode_komoditas');
        });

        /**
         * KATEGORI BEBAN (Tetap / Variabel dll)
         */
        Schema::create('kategori', function (Blueprint $table) {
            $table->bigIncrements('id_kategori');
            $table->string('kode_kategori');
            $table->string('keterangan');
            $table->timestamps();

            $table->unique('kode_kategori');
        });

        /**
         * BEBAN (Pupuk, Benih, Tenaga Kerja, dll.)
         */
        Schema::create('bebans', function (Blueprint $table) {
            $table->bigIncrements('id_beban');
            $table->string('kode_beban', 15);
            $table->string('nama_beban');
            $table->string('kategori'); // misal: tetap / variabel (text)
            $table->unsignedBigInteger('id_kategori');
            $table->timestamps();

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->unique('kode_beban');
        });

        /**
         * BEBAN FIX (tabel terpisah untuk beban tetap agregat)
         */
        Schema::create('bebanfixes', function (Blueprint $table) {
            $table->bigIncrements('id_bebanfix');
            $table->string('kode_beban_fix')->nullable();
            $table->string('keterangan')->nullable();
            // perbaikan: nominal decimal
            $table->decimal('nominal', 15, 2)->nullable();
            $table->timestamps();
        });

        /**
         * TANAM (Season / usaha tani per lahan + komoditas)
         */
        Schema::create('tanams', function (Blueprint $table) {
            $table->bigIncrements('id_tanam');
            $table->string('kode_tanam', 15);
            $table->foreignId('id_lahan')
                ->constrained('lahans', 'id_lahan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('id_komoditas')
                ->constrained('komoditas', 'id_komoditas')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('tgl_tanam');
            $table->date('tgl_panen')->nullable();

            // Perbaikan tipe data numeric
            $table->decimal('volume_panen', 15, 2)->nullable();   // total hasil panen (Rp atau kg, sesuai konsep)
            $table->decimal('beban_variabel', 15, 2)->nullable()->default(0);
            $table->decimal('beban_fix', 15, 2)->nullable()->default(0);
            $table->decimal('keuntungan', 15, 2)->nullable();     // volume_panen - total_beban

            $table->timestamps();

            $table->unique('kode_tanam');
        });

        /**
         * BEBAN PER TANAM (detail biaya produksi)
         */
        Schema::create('bebantanam', function (Blueprint $table) {
            $table->bigIncrements('id_bebantanam');
            $table->string('kode_bebantanam');
            $table->foreignId('id_tanam')
                ->constrained('tanams', 'id_tanam')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('id_beban')
                ->constrained('bebans', 'id_beban')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('satuan', 11);
            $table->integer('jumlah');
            // perbaikan: harga & total sebaiknya decimal
            $table->decimal('harga', 15, 2);
            $table->decimal('total', 15, 2)->nullable();
            $table->timestamps();

            $table->unique('kode_bebantanam');
        });

        /**
         * PANEN
         */
        Schema::create('panens', function (Blueprint $table) {
            $table->bigIncrements('id_panen');
            $table->string('kode_panen');
            $table->foreignId('id_tanam')
                ->constrained('tanams', 'id_tanam')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('tgal_panen');
            $table->integer('jumlah'); // misal berapa kali panen / berapa unit
            // harga per unit
            $table->decimal('harga', 15, 2);
            // perbaikan: hasil_panen decimal
            $table->decimal('hasil_panen', 15, 2);
            $table->timestamps();

            $table->unique('kode_panen');
        });

        /**
         * IMPORT ANGGOTA (log import)
         */
        Schema::create('importanggotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('importanggotas');
        Schema::dropIfExists('panens');
        Schema::dropIfExists('bebantanam');
        Schema::dropIfExists('tanams');
        Schema::dropIfExists('bebanfixes');
        Schema::dropIfExists('bebans');
        Schema::dropIfExists('kategori');
        Schema::dropIfExists('komoditas');
        Schema::dropIfExists('lahans');
        Schema::dropIfExists('anggotatanis');
        Schema::dropIfExists('kelompoktanis');
    }
};
