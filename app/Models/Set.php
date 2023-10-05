<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{
    protected $table = 'set';
    protected $fillable = ['id', 'id_set', 'name', 'series', 'printedTotal', 'total', 'ptcgoCode', 'releaseDate', 'updatedAt', 'symbol', 'logo'];

    // Relations avec d'autres modèles
    public function legalities()
    {
        return $this->hasMany(Legality::class, 'set_id');
    }
}
