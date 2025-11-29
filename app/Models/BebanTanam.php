<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BebanTanam extends Model
{
    protected $table = 'bebantanam';
    protected $primaryKey = 'id_bebantanam';

    protected $fillable = [
        'kode_bebantanam',
        'id_tanam',
        'id_beban',
        'satuan',
        'jumlah',
        'harga',
        'total',
    ];

    public function tanam()
    {
        return $this->belongsTo(Tanam::class, 'id_tanam', 'id_tanam');
    }

    public function beban()
    {
        return $this->belongsTo(Beban::class, 'id_beban', 'id_beban');
    }
}
