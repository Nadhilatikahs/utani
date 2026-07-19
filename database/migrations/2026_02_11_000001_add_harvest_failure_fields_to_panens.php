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
            $table->enum('harvest_status', ['successful', 'partially_failed', 'fully_failed'])
                ->default('successful')
                ->after('hasil_panen');

            $table->enum('failure_cause', [
                    'pest',
                    'plant_disease',
                    'extreme_weather',
                    'flood',
                    'drought',
                    'technical_error',
                    'other',
                ])
                ->nullable()
                ->after('harvest_status');

            $table->text('notes')->nullable()->after('failure_cause');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('panens', function (Blueprint $table) {
            $table->dropColumn(['harvest_status', 'failure_cause', 'notes']);
        });
    }
};

