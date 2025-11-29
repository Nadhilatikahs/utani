<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * JENIS TRANSAKSI (header besar: Pendapatan, Beban, dll.)
         */
        Schema::create('jenis_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('keterangan', 50)->nullable();
        });

        /**
         * DETAIL JENIS TRANSAKSI (sub-jenis, kalau mau dipakai)
         */
        Schema::create('detail_jenis_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_jenis_transaksi');
            $table->string('keterangan', 50);
        });

        /**
         * CHART OF ACCOUNTS (daftar akun)
         */
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode_akun', 10);
            $table->unsignedInteger('id_jenis_transaksi');
            $table->string('nama_akun', 100);
            $table->string('header', 50);
            $table->string('posisi_dr_cr', 50);
            // perbaikan: saldo_awal decimal
            $table->decimal('saldo_awal', 15, 2)->default(0);
        });

        /**
         * ARUS KAS SEDERHANA
         */
        Schema::create('arus_kas', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['masuk', 'keluar']);
            $table->decimal('amount', 15, 2);
            $table->timestamp('created_at')->useCurrent();
        });

        /**
         * TABEL LAPORAN RINGKAS (kaitkan ke arus_kas)
         */
        Schema::create('laporan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('arus_kas_id')->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->decimal('saldo', 15, 2)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        /**
         * CASH TRANSACTIONS (versi lain, lengkap dengan tanggal & deskripsi)
         */
        Schema::create('cash_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('transaction_type', ['masuk', 'keluar']);
            $table->date('transaction_date');
            $table->decimal('amount', 15, 2);
            $table->text('description')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        /**
         * TRANSAKSI HEADER (TRXxxx) - rekap transaksi
         */
        Schema::create('transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('transaksi_id', 50)->nullable();
            $table->date('tgl_transaksi')->nullable();
            $table->integer('total')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->string('jenis_transaksi', 100)->nullable();
            $table->string('detail_jenis_transaksi', 100)->nullable();
        });

        /**
         * KAS TRANSAKSI (versi lain)
         */
        Schema::create('kas_transaksi', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('jenis_transaksi', ['Masuk', 'Keluar']);
            $table->string('deskripsi', 255);
            $table->decimal('jumlah', 15, 2);
            $table->timestamp('tanggal')->useCurrent();
        });

        /**
         * TRANSACTIONS (versi lain, dengan account_id)
         */
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date')->useCurrent();
            $table->enum('type', ['kas masuk', 'kas keluar']);
            $table->decimal('amount', 15, 2);
            $table->text('description');
            $table->integer('account_id');
        });

        /**
         * JURNAL KAS (kas masuk/keluar dengan deskripsi)
         */
        Schema::create('jurnal_kas', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['masuk', 'keluar']);
            $table->decimal('amount', 15, 2);
            $table->text('description');
            $table->timestamp('created_at')->useCurrent();
        });

        /**
         * JURNAL RINGKAS (saldo kas berjalan)
         */
        Schema::create('jurnal', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal');
            $table->string('keterangan', 255);
            $table->decimal('kas_masuk', 15, 2)->default(0);
            $table->decimal('kas_keluar', 15, 2)->default(0);
            $table->decimal('saldo', 15, 2);
        });

        /**
         * JURNALL (log detail debit / kredit)
         */
        Schema::create('jurnall', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal');
            $table->integer('transaksi_id')->nullable();
            $table->string('keterangan', 255)->nullable();
            $table->decimal('debet', 15, 2)->default(0);
            $table->decimal('kredit', 15, 2)->default(0);
        });

        /**
         * JURNALS (table skeleton bawaan Laravel tadi, dibiarkan generik)
         */
        Schema::create('jurnals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });

        /**
         * JURNAL UMUM (model jurnal double entry)
         */
        Schema::create('jurnal_umum', function (Blueprint $table) {
            $table->increments('id');
            $table->string('id_jurnal', 50);
            $table->date('tgl_jurnal');
            $table->integer('no_coa');
            $table->string('posisi_dr_cr', 50);
            $table->decimal('nominal', 15, 2);
        });

        /**
         * JOURNAL (daftar akun + debit/kredit)
         */
        Schema::create('journal', function (Blueprint $table) {
            $table->bigIncrements('No'); // dari dump
            $table->string('akun');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('kredit', 15, 2)->default(0);
            $table->timestamps();
        });

        /**
         * JOURNAL ENTRIES (detail per tanggal & akun)
         */
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('date')->useCurrent();
            $table->integer('account_id');
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->text('description');
        });

        /**
         * LAPORANS (table skeleton Laravel)
         */
        Schema::create('laporans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
        });

        /**
         * PENCATATAN KAS (format sederhana manual)
         * Di dump: nominal masih varchar, di sini aku perbaiki ke decimal
         */
        Schema::create('pencatatan_kas', function (Blueprint $table) {
            $table->increments('id'); // tambahan PK
            $table->string('kode_transaksi', 50);
            $table->date('tanggal_transaksi');
            $table->string('jenis_transaksi', 50);
            $table->string('posisi_dr_cr', 30);
            $table->decimal('nominal', 15, 2);
            $table->string('keterangan', 100);
            $table->string('kode_akun', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pencatatan_kas');
        Schema::dropIfExists('laporans');
        Schema::dropIfExists('journal_entries');
        Schema::dropIfExists('journal');
        Schema::dropIfExists('jurnal_umum');
        Schema::dropIfExists('jurnals');
        Schema::dropIfExists('jurnall');
        Schema::dropIfExists('jurnal');
        Schema::dropIfExists('jurnal_kas');
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('kas_transaksi');
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('cash_transactions');
        Schema::dropIfExists('laporan');
        Schema::dropIfExists('arus_kas');
        Schema::dropIfExists('chart_of_accounts');
        Schema::dropIfExists('detail_jenis_transaksi');
        Schema::dropIfExists('jenis_transaksi');
    }
};
