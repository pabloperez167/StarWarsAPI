<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Starship;
use App\Models\Pilot;
use Illuminate\Http\Request;

class StarshipController extends Controller
{
    public function showStarships()
    {
        return response()->json(Starship::all(), 200);
    }

    public function showPilots()
    {
        return response()->json(Pilot::all(), 200);
    }

    public function getStarshipxid($id)
    {
        $starship = Starship::find($id);
        if (is_null($starship)) {
            return response()->json(['Mensaje' => 'Registro no encontrado'], 404);
        }
        return response()->json($starship, 200);
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

        // Obtener los nombres de los pilotos asociados a la nave
        $pilotosNombres = $starship->pilots()->pluck('name')->toArray();

        // Actualizar la columna 'pilotos' en la tabla 'starships' como un array JSON
        $starship->update(['pilotos' => json_encode($pilotosNombres)]);

        return response()->json(['message' => 'Piloto agregado a la nave espacial']);
    }




    public function deletePilot($starshipId, $pilotId)
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

        // Deasociar el piloto a la nave espacial
        $starship->pilots()->detach($pilot->id);
        // Obtener los nombres de los pilotos asociados a la nave
        $pilotosNombres = $starship->pilots()->pluck('name')->toArray();

        // Actualizar la columna 'pilotos' en la tabla 'starships' como un array JSON
        $starship->update(['pilotos' => json_encode($pilotosNombres)]);

        return response()->json(['message' => 'Se ha eliminado el piloto de la nave espacial']);
    }

    public function eliminarPiloto($starshipId, $pilotId)
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

        // Deasociar el piloto a la nave espacial
        $starship->pilots()->detach($pilot->id);
        // Obtener los nombres de los pilotos asociados a la nave
        $pilotosNombres = $starship->pilots()->pluck('name')->toArray();

        // Actualizar la columna 'pilotos' en la tabla 'starships' como un array JSON
        $starship->update(['pilotos' => json_encode($pilotosNombres)]);
        $pilot->delete();

        return response()->json(['message' => 'Se ha eliminado el piloto de la nave espacial']);
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Crear el nuevo piloto
        $piloto = Pilot::create([
            'name' => $validatedData['name'],
        ]);

        return response()->json(['message' => 'Piloto creado exitosamente', 'piloto' => $piloto], 201);
    }





}