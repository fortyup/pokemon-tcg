<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Legality extends Model
{
    protected $table = 'legalities';
    protected $fillable = ['id', 'format','status', 'set_id'];

    // Relation avec le modèle Set
    public function set()
    {
        return $this->belongsTo(Set::class, 'set_id');
    }
}
