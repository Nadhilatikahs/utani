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
        Schema::create('panens', function (Blueprint $table) {
            $table->id('id_panen');
            $table->string('kode_panen');
            $table->foreignid('id_tanam')->constrained;
            $table->date('tgal_panen');
            $table->decimal('jumlah', 10, 2);
            $table->decimal('harga', 10, 2);
            $table->string('hasil_panen');
            
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panens');
    }
};
