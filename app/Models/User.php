<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relations avec d'autres modèles
    public function collections()
    {
        return $this->hasMany(Collection::class, 'user_id');
    }

    public function hasCard(Card $card)
    {
        $collection = Collection::where('user_id', $this->id)->where('card_id', $card->id)->first();
        return $collection != null;
    }

    public function hasAllSetCards(Set $set)
    {
        $cards = $set->cards;
        foreach ($cards as $card) {
            if (!$this->hasCard($card)) {
                return false;
            }
        }
        return true;
    }
}
