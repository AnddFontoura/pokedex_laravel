<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use App\Models\PokemonHasType;
use Illuminate\Http\Request;

class PokedexController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all();
        $pokemon = null;
        $types = null;

        $pokemons = Pokemon::select();

        $pokemons = $pokemons->orderBy('api_id', 'asc')
                ->get();

        if (isset($filters['pokemon_id'])) {
            $pokemon = Pokemon::where('api_id', $filters['pokemon_id'])
                ->first();

            $types = PokemonHasType::where('pokemon_id', $filters['pokemon_id'])
                ->get();
        }

        return view('pokedex', compact('pokemons','pokemon','types'));
    }
}
