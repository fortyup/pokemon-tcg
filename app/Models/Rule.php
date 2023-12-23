<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $table = 'rule';
    protected $fillable = ['id', 'rule', 'card_id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'rule' => 'array',
    ];

    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

}
