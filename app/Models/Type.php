<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $table = 'type';

    protected $fillable = [
        'id',
        'type',
        'card_id',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }
}
