<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'rules';
    protected $fillable = ['id', 'rule', 'card_id'];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

}
