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
        Schema::create('tanams', function (Blueprint $table) {
            $table->id('id_tanam');
            $table->bigInteger('id_lahan')->unsigned();
            $table->bigInteger('id_komoditas')->unsigned();
            $table->date('tgl_tanam');
            $table->date('tgl_panen');
            $table->float('volume_panen');
            $table->float('beban_variabel');
            $table->float('beban_fix');
            $table->float('keuntungan');
            
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanams');
    }
};
