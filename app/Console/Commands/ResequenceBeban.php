<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResequenceBeban extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'beban:resequence';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resequence all Beban codes sequentially starting from BB-001 ordered by id_beban';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting Beban resequencing...');

        DB::transaction(function () {
            // 1. Temporarily update all kode_beban to TMP-{id_beban} to prevent unique constraint conflicts
            DB::statement("UPDATE bebans SET kode_beban = CONCAT('TMP-', id_beban)");

            // 2. Fetch all bebans sorted by id_beban
            $bebans = DB::table('bebans')->orderBy('id_beban')->get();
            $count = 0;

            foreach ($bebans as $beban) {
                $count++;
                $newCode = 'BB-' . str_pad($count, 3, '0', STR_PAD_LEFT);
                DB::table('bebans')
                    ->where('id_beban', $beban->id_beban)
                    ->update(['kode_beban' => $newCode]);
            }

            // 3. Update kode_sequences table next_number to match the count
            DB::table('kode_sequences')->updateOrInsert(
                ['nama_tabel' => 'bebans'],
                ['next_number' => $count]
            );

            $this->info("Successfully resequenced {$count} Beban records.");
        });

        return Command::SUCCESS;
    }
}
