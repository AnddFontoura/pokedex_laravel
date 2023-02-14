<?php

namespace App\Console\Commands;

use App\Models\Pokemon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class getPokemonInformationCommand extends Command
{
    protected $valorPreDefinido = 150;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:get-pokemon-information';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retorna os dados de um pokemon';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Iniciando Comando dos Pokemons');

        $progressBar = $this->output->createProgressBar($this->valorPreDefinido);
        $progressBar->start();

        for($i = 1; $i <= $this->valorPreDefinido; $i++) {
            $client = new Client();
            $response = $client->get('https://pokeapi.co/api/v2/pokemon/' . $i);
            $pokemonData = json_decode($response->getBody()->getContents());

            $url = $pokemonData->types[0]->type->url;
            $explodeUrl = explode('/', $url);
            $typeId = $explodeUrl[sizeof($explodeUrl) - 2];

            $pokemonExists = Pokemon::where('api_id', $pokemonData->id)
                ->where('name', $pokemonData->name)
                ->first();

            if (!$pokemonExists) {
                Pokemon::create([
                    'api_id' => $pokemonData->id,
                    'name' => $pokemonData->name,
                    'type_id' => $typeId
                ]);
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        return Command::SUCCESS;
    }
}
