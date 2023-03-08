<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Pokemon;
use App\Models\PokemonHasType;
use App\Models\Type;
use App\Rules\PokemonApiSearchRule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PokemonApiController extends Controller
{
    public function getPokemon(Request $request)
    {
        $parameters = $request->all();

        $pokemons = Pokemon::select();
        
        if (!isset($parameters['limit'])) {
            return response()->json(['error' => 'Parametro Incompleto'], Response::HTTP_BAD_REQUEST);
        } else {
            $pokemons = $pokemons->limit($parameters['limit']);
        }

        if (!isset($parameters['offset'])) {
            return response()->json(['error' => 'Parametro Incompleto'], Response::HTTP_BAD_REQUEST);
        } else {
            $pokemons = $pokemons->offset($parameters['offset']);
        }

        if (isset($parameters['partial_name'])) {
            $pokemons = $pokemons->where('name', 'like', '%' . $parameters['partial_name'] . '%');
        }

        $pokemons = $pokemons->get();

        return response()->json($pokemons, Response::HTTP_OK);
    }

    public function getTypes(Request $request)
    {
        $this->validate($request, [
            'id' => 'nullable|int|min:1'
        ]);
        
        $parameters = $request->all();

        $types = Type::select();

        if (isset($parameters['id'])) {
            $type = $types->where('id', $parameters['id']);
        }

        $types = $types->get();

        return response()->json($types, Response::HTTP_OK);
    }

    public function getPokemonsByType(Request $request)
    {
        $parameters = $request->all();

        if(!isset($parameters['id']) && !is_integer($parameters['id'])) {
            return response()->json(['error' => 'Você precisa enviar um ID'], Response::HTTP_BAD_REQUEST);
        }

        /* Maneira sem Inner Join
        $pokemonsHasTypes = PokemonHasType::where('type_id', $parameters['id'])->get();
        $pokemonsArray = [];

        foreach($pokemonsHasTypes as $pokemons) {
            $pokemonData = Pokemon::where('id', $pokemons['pokemon_id'])->first();
            
            $pokemonsArray[] = $pokemonData;
        }
        */

        /* Inner join a partir de Pokemon 
        $pokemonsArray = Pokemon::join('pokemons_has_types', 'pokemons.id', '=', 'pokemons_has_types.pokemon_id')
            ->where('pokemons_has_types.type_id', $request['id'])
            ->get()
            ->toArray();

        /* Inner Join a partir de Pokemon has Types */
        $pokemonsArray = PokemonHasType::join('pokemons', 'pokemons.id', '=', 'pokemons_has_types.pokemon_id')
            ->where('pokemons_has_types.type_id', $request['id'])
            ->get()
            ->toArray();
        //*/

        return response()->json($pokemonsArray, Response::HTTP_OK);
    }
}
