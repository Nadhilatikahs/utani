<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This migration adds all missing foreign key constraints to enable
     * phpMyAdmin designer to display relation lines properly.
     */
    public function up(): void
    {
        // Clean up orphaned records before adding foreign keys
        $this->cleanupOrphanedRecords();
        
        // Drop existing foreign keys if they exist (to avoid conflicts)
        $this->dropExistingForeignKeys();

        // Geographic Hierarchy Foreign Keys
        Schema::table('kabupatens', function (Blueprint $table) {
            $table->foreign('id_provinsi')
                  ->references('id_provinsi')
                  ->on('provinsis')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::table('dinas', function (Blueprint $table) {
            $table->foreign('id_kabupaten')
                  ->references('id_kabupaten')
                  ->on('kabupatens')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::table('upts', function (Blueprint $table) {
            $table->foreign('id_dinas')
                  ->references('id_dinas')
                  ->on('dinas')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::table('bpps', function (Blueprint $table) {
            $table->foreign('id_upt')
                  ->references('id_upt')
                  ->on('upts')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::table('desas', function (Blueprint $table) {
            $table->foreign('id_bpp')
                  ->references('id_bpp')
                  ->on('bpps')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::table('kelompoktanis', function (Blueprint $table) {
            $table->foreign('id_desa')
                  ->references('id_desa')
                  ->on('desas')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::table('anggotatanis', function (Blueprint $table) {
            $table->foreign('id_keltani')
                  ->references('id_keltani')
                  ->on('kelompoktanis')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        // Land and Farming Foreign Keys
        Schema::table('lahans', function (Blueprint $table) {
            $table->foreign('id_anggota')
                  ->references('id_anggota')
                  ->on('anggotatanis')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::table('tanams', function (Blueprint $table) {
            $table->foreign('id_lahan')
                  ->references('id_lahan')
                  ->on('lahans')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
            
            $table->foreign('id_komoditas')
                  ->references('id_komoditas')
                  ->on('komoditas')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::table('bebantanam', function (Blueprint $table) {
            $table->foreign('id_tanam')
                  ->references('id_tanam')
                  ->on('tanams')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            
            $table->foreign('id_beban')
                  ->references('id_beban')
                  ->on('bebans')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });

        Schema::table('panens', function (Blueprint $table) {
            $table->foreign('id_tanam')
                  ->references('id_tanam')
                  ->on('tanams')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });

        // Check if bebanfixes table exists and has id_tanam column
        if (Schema::hasTable('bebanfixes') && Schema::hasColumn('bebanfixes', 'id_tanam')) {
            Schema::table('bebanfixes', function (Blueprint $table) {
                $table->foreign('id_tanam')
                      ->references('id_tanam')
                      ->on('tanams')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }

        // Check if bebans has id_kategori column
        if (Schema::hasColumn('bebans', 'id_kategori')) {
            Schema::table('bebans', function (Blueprint $table) {
                $table->foreign('id_kategori')
                      ->references('id_kategori')
                      ->on('kategori')
                      ->onDelete('restrict')
                      ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop all foreign keys in reverse order
        $this->dropExistingForeignKeys();
    }

    /**
     * Clean up orphaned records that would violate foreign key constraints
     */
    private function cleanupOrphanedRecords(): void
    {
        // Clean up bebantanam with invalid id_tanam using a safer approach
        if (Schema::hasTable('bebantanam') && Schema::hasTable('tanams')) {
            $validIds = DB::table('tanams')->pluck('id_tanam')->toArray();
            if (!empty($validIds)) {
                DB::table('bebantanam')->whereNotIn('id_tanam', $validIds)->delete();
            } else {
                // If no valid tanams exist, delete all bebantanam
                DB::table('bebantanam')->delete();
            }
        }

        // Clean up bebantanam with invalid id_beban
        if (Schema::hasTable('bebantanam') && Schema::hasTable('bebans')) {
            $validIds = DB::table('bebans')->pluck('id_beban')->toArray();
            if (!empty($validIds)) {
                DB::table('bebantanam')->whereNotIn('id_beban', $validIds)->delete();
            }
        }

        // Clean up panens with invalid id_tanam
        if (Schema::hasTable('panens') && Schema::hasTable('tanams')) {
            $validIds = DB::table('tanams')->pluck('id_tanam')->toArray();
            if (!empty($validIds)) {
                DB::table('panens')->whereNotIn('id_tanam', $validIds)->delete();
            } else {
                DB::table('panens')->delete();
            }
        }

        // Clean up bebanfixes with invalid id_tanam
        if (Schema::hasTable('bebanfixes') && Schema::hasTable('tanams') && Schema::hasColumn('bebanfixes', 'id_tanam')) {
            $validIds = DB::table('tanams')->pluck('id_tanam')->toArray();
            if (!empty($validIds)) {
                DB::table('bebanfixes')->whereNotIn('id_tanam', $validIds)->delete();
            } else {
                DB::table('bebanfixes')->delete();
            }
        }

        // Clean up tanams with invalid id_lahan
        if (Schema::hasTable('tanams') && Schema::hasTable('lahans')) {
            $validIds = DB::table('lahans')->pluck('id_lahan')->toArray();
            if (!empty($validIds)) {
                DB::table('tanams')->whereNotIn('id_lahan', $validIds)->delete();
            }
        }

        // Clean up tanams with invalid id_komoditas
        if (Schema::hasTable('tanams') && Schema::hasTable('komoditas')) {
            $validIds = DB::table('komoditas')->pluck('id_komoditas')->toArray();
            if (!empty($validIds)) {
                DB::table('tanams')->whereNotIn('id_komoditas', $validIds)->delete();
            }
        }

        // Clean up lahans with invalid id_anggota
        if (Schema::hasTable('lahans') && Schema::hasTable('anggotatanis')) {
            $validIds = DB::table('anggotatanis')->pluck('id_anggota')->toArray();
            if (!empty($validIds)) {
                DB::table('lahans')->whereNotIn('id_anggota', $validIds)->delete();
            }
        }

        // Clean up anggotatanis with invalid id_keltani
        if (Schema::hasTable('anggotatanis') && Schema::hasTable('kelompoktanis')) {
            $validIds = DB::table('kelompoktanis')->pluck('id_keltani')->toArray();
            if (!empty($validIds)) {
                DB::table('anggotatanis')->whereNotIn('id_keltani', $validIds)->delete();
            }
        }

        // Clean up kelompoktanis with invalid id_desa
        if (Schema::hasTable('kelompoktanis') && Schema::hasTable('desas')) {
            $validIds = DB::table('desas')->pluck('id_desa')->toArray();
            if (!empty($validIds)) {
                DB::table('kelompoktanis')->whereNotIn('id_desa', $validIds)->delete();
            }
        }

        // Clean up desas with invalid id_bpp
        if (Schema::hasTable('desas') && Schema::hasTable('bpps')) {
            $validIds = DB::table('bpps')->pluck('id_bpp')->toArray();
            if (!empty($validIds)) {
                DB::table('desas')->whereNotIn('id_bpp', $validIds)->delete();
            }
        }

        // Clean up bpps with invalid id_upt
        if (Schema::hasTable('bpps') && Schema::hasTable('upts')) {
            $validIds = DB::table('upts')->pluck('id_upt')->toArray();
            if (!empty($validIds)) {
                DB::table('bpps')->whereNotIn('id_upt', $validIds)->delete();
            }
        }

        // Clean up upts with invalid id_dinas
        if (Schema::hasTable('upts') && Schema::hasTable('dinas')) {
            $validIds = DB::table('dinas')->pluck('id_dinas')->toArray();
            if (!empty($validIds)) {
                DB::table('upts')->whereNotIn('id_dinas', $validIds)->delete();
            }
        }

        // Clean up dinas with invalid id_kabupaten
        if (Schema::hasTable('dinas') && Schema::hasTable('kabupatens')) {
            $validIds = DB::table('kabupatens')->pluck('id_kabupaten')->toArray();
            if (!empty($validIds)) {
                DB::table('dinas')->whereNotIn('id_kabupaten', $validIds)->delete();
            }
        }

        // Clean up kabupatens with invalid id_provinsi
        if (Schema::hasTable('kabupatens') && Schema::hasTable('provinsis')) {
            $validIds = DB::table('provinsis')->pluck('id_provinsi')->toArray();
            if (!empty($validIds)) {
                DB::table('kabupatens')->whereNotIn('id_provinsi', $validIds)->delete();
            }
        }

        // Clean up bebans with invalid id_kategori (if column exists)
        if (Schema::hasTable('bebans') && Schema::hasColumn('bebans', 'id_kategori') && Schema::hasTable('kategori')) {
            $validIds = DB::table('kategori')->pluck('id_kategori')->toArray();
            if (!empty($validIds)) {
                DB::table('bebans')
                    ->whereNotNull('id_kategori')
                    ->whereNotIn('id_kategori', $validIds)
                    ->delete();
            }
        }
    }

    /**
     * Drop existing foreign keys to avoid conflicts
     */
    private function dropExistingForeignKeys(): void
    {
        $foreignKeys = [
            'kabupatens' => ['id_provinsi'],
            'dinas' => ['id_kabupaten'],
            'upts' => ['id_dinas'],
            'bpps' => ['id_upt'],
            'desas' => ['id_bpp'],
            'kelompoktanis' => ['id_desa'],
            'anggotatanis' => ['id_keltani'],
            'lahans' => ['id_anggota'],
            'tanams' => ['id_lahan', 'id_komoditas'],
            'bebantanam' => ['id_tanam', 'id_beban'],
            'panens' => ['id_tanam'],
        ];

        foreach ($foreignKeys as $table => $columns) {
            if (Schema::hasTable($table)) {
                foreach ($columns as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        try {
                            // Get foreign key constraint name
                            $constraints = DB::select(
                                "SELECT CONSTRAINT_NAME 
                                FROM information_schema.KEY_COLUMN_USAGE 
                                WHERE TABLE_SCHEMA = DATABASE() 
                                AND TABLE_NAME = ? 
                                AND COLUMN_NAME = ? 
                                AND REFERENCED_TABLE_NAME IS NOT NULL",
                                [$table, $column]
                            );

                            foreach ($constraints as $constraint) {
                                Schema::table($table, function (Blueprint $table) use ($constraint) {
                                    $table->dropForeign($constraint->CONSTRAINT_NAME);
                                });
                            }
                        } catch (\Exception $e) {
                            // Ignore errors if foreign key doesn't exist
                        }
                    }
                }
            }
        }

        // Handle bebanfixes separately
        if (Schema::hasTable('bebanfixes') && Schema::hasColumn('bebanfixes', 'id_tanam')) {
            try {
                $constraints = DB::select(
                    "SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'bebanfixes' 
                    AND COLUMN_NAME = 'id_tanam' 
                    AND REFERENCED_TABLE_NAME IS NOT NULL"
                );

                foreach ($constraints as $constraint) {
                    Schema::table('bebanfixes', function (Blueprint $table) use ($constraint) {
                        $table->dropForeign($constraint->CONSTRAINT_NAME);
                    });
                }
            } catch (\Exception $e) {
                // Ignore errors
            }
        }

        // Handle bebans id_kategori separately
        if (Schema::hasTable('bebans') && Schema::hasColumn('bebans', 'id_kategori')) {
            try {
                $constraints = DB::select(
                    "SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'bebans' 
                    AND COLUMN_NAME = 'id_kategori' 
                    AND REFERENCED_TABLE_NAME IS NOT NULL"
                );

                foreach ($constraints as $constraint) {
                    Schema::table('bebans', function (Blueprint $table) use ($constraint) {
                        $table->dropForeign($constraint->CONSTRAINT_NAME);
                    });
                }
            } catch (\Exception $e) {
                // Ignore errors
            }
        }
    }
};

