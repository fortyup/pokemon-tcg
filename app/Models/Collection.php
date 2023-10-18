<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';
    protected $fillable = ['user_id', 'card_id'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function cards()
    {
        return $this->belongsTo(Card::class);
    }
}
