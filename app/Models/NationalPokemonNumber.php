<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NationalPokemonNumber extends Model
{
    protected $table = 'national_pokemon_number';

    protected $fillable = [
        'id',
        'national_pokemon_number',
        'card_id',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
