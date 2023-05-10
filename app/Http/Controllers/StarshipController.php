<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Starship;
use App\Models\Pilot;

class StarshipController extends Controller
{
    public function showStarships()
    {
        // Recuperar todas las naves con sus pilotos asociados
        $starships = Starship::with('pilots')->get();

        return view('starships', ['starships' => $starships]);


    }
}
