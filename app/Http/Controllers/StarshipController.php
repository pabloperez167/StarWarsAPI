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

    public function getStarshipxid($id){
        $starship= Starship::find($id);
        if(is_null($starship)){
            return response()-> json(['Mensaje' => 'Registro no encontrado'],404);
        }
        return response() -> json($starship::find($id),200);
    }

    public function deletePilot($id)
{
    // Encuentra la nave por su ID
    $starship = Starship::findOrFail($id);

    // Verifica si la nave tiene un piloto asociado
    if (!empty($starship->piloto)) {
        // Elimina el piloto de la nave
        $starship->update(['piloto' => null]);

        // Retorna una respuesta adecuada (por ejemplo, un mensaje de éxito)
        return response()->json(['message' => 'Pilot deleted successfully'], 200);
    } else {
        // Retorna una respuesta de error si la nave no tiene un piloto asociado
        return response()->json(['message' => 'No pilot associated with the starship'], 404);
    }
}

    
    public function addPilotToStarship($id)
{
    $starship = Starship::find($id);

    if ($starship) {
        // Crea un nuevo piloto o selecciona un piloto existente
        $piloto = Pilot::firstOrCreate(['name' => 'Nuevo Piloto']);
        
        // Asocia el piloto a la nave
        $starship->update(['piloto' => $piloto->name]);

        return response()->json(['message' => 'Pilot added to starship successfully'], 200);
    } else {
        return response()->json(['message' => 'Starship not found'], 404);
    }
}



}
    






