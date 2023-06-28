<?php

namespace App\Console\Commands;

//Importa la clase base Command de Laravel que se utilizará como base para crear el comando de consola.
use Illuminate\Console\Command;
//Importa la clase Client del paquete GuzzleHttp para realizar solicitudes HTTP a la API de Star Wars.
use GuzzleHttp\Client;
use App\Models\Starship;
use App\Models\Pilot;

class ImportStarshipsAndPilots extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'import:starships-and-pilots';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Import starships and pilots from SWAPI';

    /**
     * Execute the console command.
     */

    //Este método es el punto de entrada del comando y se ejecutará cuando se invoque el comando.
    public function handle()
    {
        // Crea una instancia del cliente HTTP de Guzzle para realizar solicitudes a la API de Star Wars.
        $client = new Client();
        $page = 1;

        // Realizamos solicitudes HTTP hasta llegar a la página 4
        while ($page <= 4) {
            $response = $client->request('GET', 'https://swapi.dev/api/starships/', [
                'query' => [
                    'page' => $page
                ]
            ]);
            //Decodifica la respuesta de la API (que está en formato JSON) en un array asociativo utilizando la función json_decode().
            //La información de las naves espaciales y pilotos estará en el índice 'results' del array.
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
                        $piloto['name'] = str_replace('é', 'e', $piloto['name']);


                        if (!$pilotoExistente) {
                            $pilotoExistente = Pilot::create([

                                'name' => $piloto['name']
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
                    'pilotos' => json_encode($pilotNames),
                    // Convertir el array de nombres de pilotos a JSON
                    'coste' => $coste
                ]);
                //Establece la relacion muchos a muchos entre la nave espacial y los pilotos 
                //utilizando el metodo sync(), que sincroniza los IDs de los pilotos en la tabla pivot correspondiente.
                $starship->pilots()->sync($pilotId);
            }
            $page++;
        }


        $this->info('Import completed.');

    }





}