<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attack extends Model
{
    protected $table = 'attack';

    protected $fillable = [
        'id',
        'name',
        'cost',
        'convertedEnergyCost',
        'damage',
        'text',
        'card_id',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
