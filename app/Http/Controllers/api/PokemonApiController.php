<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Pokemon;
use App\Rules\PokemonApiSearchRule;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PokemonApiController extends Controller
{
    public function search(Request $request)
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

        if (isset($parameters['type'])) {
            $pokemons = $pokemons->where('type_id', $parameters['type']);
        }

        $pokemons = $pokemons->get();

        return response()->json($pokemons, Response::HTTP_OK);
    }
}
