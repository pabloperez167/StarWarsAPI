<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Starship;
use App\Models\Pilot;


/**Con este test, cada vez que lo ejecutamos nos crea una instancia de nave y de piloto
 * aparecen asociados en la tabla pilots_starship del laravel-test
 * Ademas aparece el nombre del piloto junto con la nave en la tabla starship-> pilotos
 */
class StarshipTest extends TestCase
{
   //use RefreshDatabase;
    public function testPilotValuesAreCorrectlySaved()
{
    // Crea una nave espacial y un piloto
    $starship = Starship::factory()->create();
    $pilot = Pilot::factory()->create();

    // Asocia el piloto con la nave espacial utilizando el método attach()
    $starship->pilots()->attach($pilot);

     // Verifica si el piloto está presente en la relación
     $this->assertContains($pilot->id, $starship->pilots()->pluck('id'));

      // Obtener los nombres de los pilotos asociados a la nave
      $pilotosNombres = $starship->pilots()->pluck('name')->toArray();

      // Actualizar la columna 'pilotos' en la tabla 'starships' como un array JSON
      $starship->update(['pilotos' => json_encode($pilotosNombres)]);
}


}
