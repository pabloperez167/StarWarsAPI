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
            // ...

            foreach ($data['results'] as $nave) {

                $coste = $nave['cost_in_credits'];
                        if ($coste === 'unknown') {
                            $coste = 0;
                        }

                if (!empty($nave['pilots'])) {
                    foreach ($nave['pilots'] as $urlPiloto) {
                        $response = $client->request('GET', $urlPiloto);
                        $piloto = json_decode($response->getBody(), true);

                        $pilotoExistente = Pilot::where('name', $piloto['name'])->first();

                        if (!$pilotoExistente) {
                            $pilotoExistente = Pilot::create([
                                'name' => $piloto['name']
                                // Agrega más atributos del piloto que deseas guardar
                            ]);
                        }

                    
                        $starship = Starship::create([
                            'name' => $nave['name'],
                            'model' => $nave['model'],
                            'piloto' => $piloto['name'],
                            'coste' => $coste

                        ]);

                        // Establecer la relación en la tabla pivote
                        $starship->pilots()->attach($pilotoExistente, ['starship_id' => $starship->id]);
                    }
                }
                $starship = Starship::create([
                    'name' => $nave['name'],
                    'model' => $nave['model'],
                    'coste' => $coste

                ]);
            }

            // ...


            $page++;
        }


        $this->info('Import completed.');

    }





}