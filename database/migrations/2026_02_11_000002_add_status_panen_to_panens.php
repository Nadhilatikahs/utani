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
        Schema::table('panens', function (Blueprint $table) {
            $table->enum('status_panen', ['berhasil', 'gagal_sebagian', 'gagal_total'])
                ->default('berhasil')
                ->after('hasil_panen');

            $table->enum('penyebab_gagal', [
                    'hama',
                    'penyakit',
                    'cuaca_ekstrem',
                    'banjir',
                    'kekeringan',
                    'kesalahan_teknis',
                    'lainnya',
                ])
                ->nullable()
                ->after('status_panen');

            $table->text('keterangan')->nullable()->after('penyebab_gagal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('panens', function (Blueprint $table) {
            $table->dropColumn(['status_panen', 'penyebab_gagal', 'keterangan']);
        });
    }
};

