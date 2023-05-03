<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Starship;
use App\Models\Pilot;

class ImportStarshipsAndPilots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:starships-and-pilots';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import starships and pilots from SWAPI';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $client = new Client();

         // Obtener todas las naves
         $response = $client->get('https://swapi.dev/api/starships');
         $starshipsData = json_decode($response->getBody(), true)['results'];

         foreach ($starshipsData as $starshipData) {
            // Guardar cada nave en la base de datos
            Starship::create([
                'name' => $starshipData['name'],
                'model' => $starshipData['model'],
                // Agrega más atributos de la nave que deseas guardar
            ]);
             // Obtener los pilotos de cada nave
             foreach ($starshipData['pilots'] as $pilotUrl) {
                $response = $client->get($pilotUrl);
                $pilotData = json_decode($response->getBody(), true);
                
                // Guardar cada piloto en la base de datos
                Pilot::create([
                    'name' => $pilotData['name'],
                    'height' => $pilotData['height'],
                    // Agrega más atributos del piloto que deseas guardar
                ]);
              }
        }
        $this->info('Import completed.');
    }
}
