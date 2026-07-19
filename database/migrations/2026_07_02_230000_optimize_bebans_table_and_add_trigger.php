<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Drop satuan_default and jenis_produksi columns if they exist
        Schema::table('bebans', function (Blueprint $table) {
            if (Schema::hasColumn('bebans', 'satuan_default')) {
                $table->dropColumn('satuan_default');
            }
            if (Schema::hasColumn('bebans', 'jenis_produksi')) {
                $table->dropColumn('jenis_produksi');
            }
        });

        // 2. Resolve duplicate codes before adding unique constraint
        $duplicates = DB::table('bebans')
            ->select('kode_beban')
            ->groupBy('kode_beban')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('kode_beban');

        foreach ($duplicates as $code) {
            $records = DB::table('bebans')
                ->where('kode_beban', $code)
                ->orderBy('id_beban')
                ->get();

            // The first record retains the duplicate code. All others are renamed.
            for ($i = 1; $i < count($records); $i++) {
                $maxCode = DB::table('bebans')
                    ->selectRaw("MAX(CAST(SUBSTRING(kode_beban, 4) AS UNSIGNED)) as max_num")
                    ->value('max_num');
                $nextNum = ($maxCode ?? 0) + 1;
                $nextCode = 'BB-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

                DB::table('bebans')
                    ->where('id_beban', $records[$i]->id_beban)
                    ->update(['kode_beban' => $nextCode]);
            }
        }

        // 3. Make kode_beban unique
        Schema::table('bebans', function (Blueprint $table) {
            $table->unique('kode_beban');
        });

        // 4. Create sequence table if not exists
        if (!Schema::hasTable('kode_sequences')) {
            Schema::create('kode_sequences', function (Blueprint $table) {
                $table->string('nama_tabel', 50)->primary();
                $table->integer('next_number');
            });
        }

        // 5. Initialize sequence number for bebans table
        $maxCode = DB::table('bebans')
            ->selectRaw("MAX(CAST(SUBSTRING(kode_beban, 4) AS UNSIGNED)) as max_num")
            ->value('max_num');
        $nextNum = $maxCode ?? 0;

        DB::table('kode_sequences')->updateOrInsert(
            ['nama_tabel' => 'bebans'],
            ['next_number' => $nextNum]
        );

        // 6. Create trigger
        DB::unprepared("DROP TRIGGER IF EXISTS trg_bebans_before_insert");
        DB::unprepared("
            CREATE TRIGGER trg_bebans_before_insert
            BEFORE INSERT ON bebans
            FOR EACH ROW
            BEGIN
                UPDATE kode_sequences
                SET next_number = LAST_INSERT_ID(next_number + 1)
                WHERE nama_tabel = 'bebans';

                SET NEW.kode_beban = CONCAT('BB-', LPAD(LAST_INSERT_ID(), 3, '0'));
            END
        ");

        // 7. Create kelompok_biaya_produksis master table
        if (!Schema::hasTable('kelompok_biaya_produksis')) {
            Schema::create('kelompok_biaya_produksis', function (Blueprint $table) {
                $table->id('id_kelompok_biaya_produksi');
                $table->string('kode_kelompok', 10);
                $table->string('nama_kelompok', 100);
                $table->timestamps();
            });
        }

        // 8. Seed kelompok_biaya_produksis
        DB::table('kelompok_biaya_produksis')->updateOrInsert(
            ['id_kelompok_biaya_produksi' => 1],
            ['kode_kelompok' => 'BBB', 'nama_kelompok' => 'Beban Bahan Baku', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('kelompok_biaya_produksis')->updateOrInsert(
            ['id_kelompok_biaya_produksi' => 2],
            ['kode_kelompok' => 'BTKL', 'nama_kelompok' => 'Beban Tenaga Kerja Langsung', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('kelompok_biaya_produksis')->updateOrInsert(
            ['id_kelompok_biaya_produksi' => 3],
            ['kode_kelompok' => 'BOP', 'nama_kelompok' => 'Beban Overhead Pabrik', 'created_at' => now(), 'updated_at' => now()]
        );

        // 9. Add id_kelompok_biaya_produksi to bebans table
        if (!Schema::hasColumn('bebans', 'id_kelompok_biaya_produksi')) {
            Schema::table('bebans', function (Blueprint $table) {
                $table->bigInteger('id_kelompok_biaya_produksi')->unsigned()->nullable()->after('id_kategori');
                $table->foreign('id_kelompok_biaya_produksi')
                      ->references('id_kelompok_biaya_produksi')
                      ->on('kelompok_biaya_produksis')
                      ->onDelete('restrict')
                      ->onUpdate('cascade');
            });
        }

        // 10. Restore id_kategori from utani database if available
        try {
            DB::statement("
                UPDATE utanixyz.bebans AS baru
                JOIN utani.bebans AS lama 
                    ON baru.kode_beban = lama.kode_beban
                SET baru.id_kategori = lama.id_kategori
            ");
        } catch (\Exception $e) {
            // Skip if utani database is not accessible
        }

        // 11. Auto-classify existing bebans to id_kelompok_biaya_produksi
        $allBebans = DB::table('bebans')->get();
        foreach ($allBebans as $b) {
            $text = mb_strtolower(trim(($b->nama_beban ?? '') . ' ' . ($b->kategori ?? '')));
            $contains = function($needle) use ($text) {
                return $needle !== '' && mb_strpos($text, mb_strtolower($needle)) !== false;
            };

            $guessedId = 3; // Default to BOP
            if (
                $contains('benih') ||
                $contains('bibit') ||
                $contains('pupuk') ||
                $contains('herbisida') ||
                $contains('insektisida') ||
                $contains('fungisida') ||
                $contains('pestisida') ||
                $contains('obat')
            ) {
                $guessedId = 1;
            } elseif (
                $contains('upah') ||
                $contains('gaji') ||
                $contains('buruh') ||
                $contains('tenaga kerja') ||
                $contains('tanam') ||
                $contains('panen') ||
                $contains('angkut')
            ) {
                $guessedId = 2;
            }

            DB::table('bebans')->where('id_beban', $b->id_beban)->update(['id_kelompok_biaya_produksi' => $guessedId]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Drop trigger
        DB::unprepared("DROP TRIGGER IF EXISTS trg_bebans_before_insert");

        // 2. Drop unique constraint
        Schema::table('bebans', function (Blueprint $table) {
            $table->dropUnique(['kode_beban']);
        });

        // 3. Drop foreign key and column id_kelompok_biaya_produksi
        Schema::table('bebans', function (Blueprint $table) {
            if (Schema::hasColumn('bebans', 'id_kelompok_biaya_produksi')) {
                $table->dropForeign(['id_kelompok_biaya_produksi']);
                $table->dropColumn('id_kelompok_biaya_produksi');
            }
        });

        // 4. Drop kelompok_biaya_produksis table
        Schema::dropIfExists('kelompok_biaya_produksis');

        // 5. Add back dropped columns if rolling back
        Schema::table('bebans', function (Blueprint $table) {
            $table->string('satuan_default', 30)->nullable()->after('nama_beban');
            $table->string('jenis_produksi')->nullable()->after('kategori');
        });

        // 6. Clean up sequence table row
        DB::table('kode_sequences')->where('nama_tabel', 'bebans')->delete();
    }
};
