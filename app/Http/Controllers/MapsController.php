<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapsController extends Controller
{
    public function map()
    {
        $data=[
            'title' => 'Pemetaan',

        ];
        return view('maps.map');
    }
}
