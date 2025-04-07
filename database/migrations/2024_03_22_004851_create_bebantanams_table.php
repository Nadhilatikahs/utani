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
        Schema::create('bebantanam', function (Blueprint $table) {
            $table->id('id_bebantanam');
            $table->foreignid('id_tanam')->constrained;
            $table->foreignid('id_beban')->constrained;
            $table->integer('satuan');
            $table->integer('jumlah');
            $table->integer('harga');
            $table->integer('total');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bebantanam');
    }
};
