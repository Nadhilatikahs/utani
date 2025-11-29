<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // JENIS TRANSAKSI
        Schema::create('jenis_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('keterangan');
        });

        // DETAIL JENIS TRANSAKSI
        Schema::create('detail_jenis_transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jenis_transaksi');
            $table->string('keterangan');

            $table->foreign('id_jenis_transaksi')
                ->references('id')
                ->on('jenis_transaksi')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        // CHART OF ACCOUNTS (COA)
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('kode_akun');
            $table->unsignedBigInteger('id_jenis_transaksi')->nullable();
            $table->string('nama_akun');
            $table->boolean('header')->default(false);
            $table->enum('posisi_dr_cr', ['DR', 'CR'])->default('DR');
            $table->decimal('saldo_awal', 14, 2)->default(0);

            $table->foreign('id_jenis_transaksi')
                ->references('id')
                ->on('jenis_transaksi')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });

        // TRANSAKSI KAS
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('transaction_type', ['masuk', 'keluar']);
            $table->date('transaction_date');
            $table->decimal('amount', 14, 2);
            $table->string('description')->nullable();
            $table->timestamps();
        });

        // JURNAL UMUM
        Schema::create('journal', function (Blueprint $table) {
            $table->id('No');
            $table->string('akun');
            $table->decimal('debit', 14, 2)->default(0);
            $table->decimal('kredit', 14, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('journal');
        Schema::dropIfExists('cash_transactions');
        Schema::dropIfExists('chart_of_accounts');
        Schema::dropIfExists('detail_jenis_transaksi');
        Schema::dropIfExists('jenis_transaksi');
    }
};
