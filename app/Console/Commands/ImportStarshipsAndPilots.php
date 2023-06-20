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
        $page = 1;

        // Realizamos solicitudes HTTP hasta llegar a la página 4
        while ($page <= 4) {
            $response = $client->request('GET', 'https://swapi.dev/api/starships/', [
                'query' => [
                    'page' => $page
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            // Recorremos cada nave y extraemos su nombre y pilotos
        foreach ($data['results'] as $nave) {
            $coste = $nave['cost_in_credits'];
            if ($coste === 'unknown') {
                $coste = 0;
            }

            $pilotNames = [];
            $pilotId = [];
            if (!empty($nave['pilots'])) {
                foreach ($nave['pilots'] as $urlPiloto) {
                    $response = $client->request('GET', $urlPiloto);
                    $piloto = json_decode($response->getBody(), true);

                    $pilotoExistente = Pilot::where('name', $piloto['name'])->first();

                    if (!$pilotoExistente) {
                        $foto = isset($piloto['foto']) ? base64_encode(file_get_contents($piloto['foto'])) : null;
                        $pilotoExistente = Pilot::create([
                            'name' => $piloto['name'],
                            'foto' => $foto
                        ]);
                    }
                    
                    // Establecer la relación en la tabla pivot
                   
                    $pilotNames[] = $piloto['name'];
                    $pilotId[] = $pilotoExistente->id; // Guardar el ID del piloto en lugar del nombre
                }
            }

            $starship = Starship::create([
                'name' => $nave['name'],
                'model' => $nave['model'],
                'pilotos' => json_encode($pilotNames), // Convertir el array de nombres de pilotos a JSON
                'coste' => $coste
            ]);
            $starship->pilots()->sync($pilotId);
        }
            $page++;
        }


        $this->info('Import completed.');

    }





}