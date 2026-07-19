<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bebans', function (Blueprint $table) {
            $table->string('satuan_default', 30)->nullable()->after('nama_beban');
        });
    }

    public function down(): void
    {
        Schema::table('bebans', function (Blueprint $table) {
            $table->dropColumn('satuan_default');
        });
    }
};

