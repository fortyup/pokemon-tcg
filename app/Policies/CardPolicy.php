<?php

namespace App\Policies;

use App\Models\Card;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CardPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user, Card $card)
    {
        // Check if the user owns the card
        return Collection::where('user_id', $user->id)->where('card_id', $card->id)->exists();
    }

    public function add(User $user, Card $card)
    {
        // Check if the user does not own the card
        return !Collection::where('user_id', $user->id)->where('card_id', $card->id)->exists();
    }
}
