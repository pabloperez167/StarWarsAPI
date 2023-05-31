<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Starship;
use App\Models\Pilot;

class StarshipTest extends TestCase
{
    use RefreshDatabase;

    public function testPilotValuesAreCorrectlySaved()
    {
        // Crea una nave espacial y un piloto
        $starship = Starship::factory()->create();
        $pilot = Pilot::factory()->create();

        // Asocia el piloto a la nave espacial
        $starship->pilots()->attach($pilot);

        // Obtén la última nave espacial y el último piloto de la base de datos
        $starshipFromDB = Starship::latest()->first();
        $pilotFromDB = Pilot::latest()->first();

        // Verifica si el piloto está asociado a la nave espacial
        $this->assertTrue($starshipFromDB->pilots->contains($pilotFromDB));
    }
}
