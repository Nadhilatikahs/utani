<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bebans', function (Blueprint $table) {
            // string saja biar fleksibel, nanti isinya: BBB / BTKL / BOP / LAIN
            $table->string('jenis_produksi')
                  ->nullable()
                  ->after('kategori'); // kategori = variabel/fix yang lama
        });
    }

    public function down(): void
    {
        Schema::table('bebans', function (Blueprint $table) {
            $table->dropColumn('jenis_produksi');
        });
    }
};
