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

            $pokemonExists = Pokemon::where('pokedex_id', $i)
                ->where('name', $pokemonData->name)
                ->first();
        
            if (!$pokemonExists) {
                Pokemon::create([
                    'pokedex_id' => $i,
                    'name' => $pokemonData->name
                ]);
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        return Command::SUCCESS;
    }
}
