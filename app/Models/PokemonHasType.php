<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PokemonHasType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "pokemons_has_types";

    protected $fillable = [
        'pokemon_id',
        'type_id'
    ];

    public function typeData()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }
}
