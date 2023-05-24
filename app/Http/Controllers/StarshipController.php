<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Starship;
use App\Models\Pilot;
use SebastianBergmann\Environment\Console;

class StarshipController extends Controller
{
    public function showStarships()
    {
        return response()->json(Starship::all(),200);
        
    }   
    
    public function showPilots()
    {
        return response()->json(Pilot::all(),200);
        
    }    


    public function getStarshipxid($id){
        $starship= Starship::find($id);
        if(is_null($starship)){
            return response()-> json(['Mensaje' => 'Registro no encontrado'],404);
        }
        return response() -> json($starship::find($id),200);
    }


    public function deletePilot($starshipId)
    {
        // Buscar la nave espacial por su ID
        $starship = Starship::find($starshipId);
    
        if (!$starship) {
            return response()->json(['message' => 'Nave espacial no encontrada'], 404);
        }
    
        // Desasociar todos los pilotos de la nave espacial
        $starship->pilots()->detach();
        $starship->update(['piloto' => null]);
    
        return response()->json(['message' => 'Se han eliminado todos los pilotos de la nave espacial']);
    }
    

    public function addPilot($starshipId, $pilotId)
    {
        // Buscar la nave espacial por su ID
        $starship = Starship::find($starshipId);
    
        if (!$starship) {
            return response()->json(['message' => 'Nave espacial no encontrada'], 404);
        }
    
        // Buscar el piloto por su ID
        $pilot = Pilot::find($pilotId);
    
        if (!$pilot) {
            return response()->json(['message' => 'Piloto no encontrado'], 404);
        }
    
        // Asociar el piloto a la nave espacial
        $starship->pilots()->attach($pilot->id);
        $starship->update(['piloto' => $pilot->name]);
        
    
        return response()->json(['message' => 'Piloto agregado a la nave espacial']);
    }
    





}
    






