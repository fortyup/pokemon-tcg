<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'card';
    protected $fillable = ['id_card', 'name', 'supertype', 'hp', 'flavorText', 'number', 'artist', 'rarity', 'smallImage', 'largeImage', 'typeWeakness', 'valueWeakness', 'typeResistance', 'valueResistance', 'retreatCost', 'convertedRetreatCost', 'set_id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'retreatCost' => 'array',
    ];

    // Relations avec d'autres modèles
    public function set()
    {
        return $this->belongsTo(Set::class, 'set_id');
    }

    public function rules()
    {
        return $this->hasMany(Rule::class, 'card_id');
    }

    public function attacks()
    {
        return $this->hasMany(Attack::class, 'card_id');
    }

    public function abilities()
    {
        return $this->hasMany(Ability::class, 'card_id');
    }

    public function types()
    {
        return $this->hasMany(Type::class, 'card_id');
    }

    public function subtypes()
    {
        return $this->hasMany(Subtype::class, 'card_id');
    }

    public function nationalPokemonNumber()
    {
        return $this->hasOne(NationalPokemonNumber::class, 'card_id');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'card_id');
    }

    public function getRouteKeyName(): string
    {
        return 'id_card';
    }
}
