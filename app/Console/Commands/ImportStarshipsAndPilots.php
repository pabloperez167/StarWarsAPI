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

                // Si la nave tiene pilotos, realizamos solicitudes HTTP para obtener sus nombres
                if (!empty($nave['pilots'])) {
                    foreach ($nave['pilots'] as $urlPiloto) {
                        $response = $client->request('GET', $urlPiloto);
                        $piloto = json_decode($response->getBody(), true);

                        // Buscamos si ya existe un piloto con el mismo nombre
                        $pilotoExistente = Pilot::where('name', $piloto['name'])->first();

                        if (!$pilotoExistente) {
                            // Si no existe, creamos un nuevo piloto
                            $pilotoExistente = Pilot::create([
                                'name' => $piloto['name']
                                // Agrega más atributos del piloto que deseas guardar
                            ]);
                        }
                        // Guardar cada nave en la base de datos
                        Starship::create([
                            'name' => $nave['name'],
                            'model' => $nave['model'],
                            'piloto' => $piloto['name']
                            // Agrega más atributos de la nave que deseas guardar
                        ]);

                    }
                }
                Starship::create([
                    'name' => $nave['name'],
                    'model' => $nave['model'],

                ]);


            }

            $page++;
        }


        $this->info('Import completed.');

    }





}