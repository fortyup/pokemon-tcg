<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Collection;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    // This method fetches all cards based on search criteria, if provided.
    public function getAllCards(Request $request)
    {
        $searchQuery = $request->input('search');
        $query = Card::query();

        // If a search query is provided, filter cards by name.
        if ($searchQuery) {
            $query->where('name', 'LIKE', '%' . $searchQuery . '%');
        }

        // Retrieve the filtered cards and all sets.
        $cards = $query->paginate(50);
        $sets = Set::all();

        // Check if each card is in the user's collection and add the 'isInCollection' flag.
        $user = Auth::user();
        $cards->each(function ($card) use ($user) {
            $card->isInCollection = $user ? Collection::where('user_id', $user->id)->where('card_id', $card->id)->first() : null;
        });

        return view('cards', ['cards' => $cards, 'sets' => $sets]);
    }

    // This method retrieves detailed information about a specific card.
    public function getCard(Card $card)
    {
        $set = $card->set;
        $subtypes = $card->subtypes;
        $types = $card->types;
        $attacks = $card->attacks;
        $rules = $card->rules;
        $abilities = $card->abilities;
        $user = Auth::user();
        if ($user)
            $isInCollection = Collection::where('user_id', $user->id)->where('card_id', $card->id)->first();
        else
            $isInCollection = null;

        return view('card', [
            'card' => $card,
            'set' => $set,
            'subtypes' => $subtypes,
            'types' => $types,
            'attacks' => $attacks,
            'rules' => $rules,
            'abilities' => $abilities,
            'isInCollection' => $isInCollection
        ]);
    }
}
