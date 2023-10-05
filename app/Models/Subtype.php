<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtype extends Model
{
    protected $table = 'subtype';

    protected $fillable = [
        'id',
        'subtype',
        'card_id',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
