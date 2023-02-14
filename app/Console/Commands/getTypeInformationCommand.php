<?php

namespace App\Console\Commands;

use App\Models\Type;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class getTypeInformationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:get-type-information';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retorna os dados de um tipo';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
        $this->info('Iniciando Comando dos Tipos');
        $i = 1;

        $bar = $this->output->createProgressBar();

        do {
            $bar->advance();
            $client = new Client();
            $response = $client->get('https://pokeapi.co/api/v2/type/' . $i);
            $typeData = json_decode($response->getBody()->getContents());

            $typeExists = Type::where('api_id', $typeData->id)
                ->where('name', $typeData->name)
                ->first();
        
            if (!$typeExists) {
                Type::create([
                    'api_id' => $typeData->id,
                    'name' => $typeData->name,
                ]);
            }
            
            $i++;
        } while ($typeData != null);

        $bar->finish();
    }
}
