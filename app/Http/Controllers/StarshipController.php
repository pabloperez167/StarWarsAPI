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
        return response()->json(Starship::all(),200);
        
    }    
    
   
    public function showStarships2()
    {
        $starships = response()->json(Starship::all(),200);
        return view('starships', compact('starships'));
        
        
    }
    
}





