<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jurnal extends Model
{
    use HasFactory;

    protected $table = 'jurnal_umum';

    protected $guarded = [];

    public $timestamps = false;

    public function doJurnal($id, $date, $no_coa, $posisi, $nominal) 
    {
        $data = [
            'id_jurnal' => $id,
            'tgl_jurnal' => $date,
            'no_coa' => $no_coa,
            'posisi_dr_cr' => $posisi,
            'nominal' => $nominal,
        ];

        DB::table($table)
            ->insert($data);
    }
}
