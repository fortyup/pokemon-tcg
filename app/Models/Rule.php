<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'rule';
    protected $fillable = ['id', 'rule', 'card_id'];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

}
