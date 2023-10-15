<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Legality;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetController extends Controller
{
    // This method retrieves a list of all sets.
    public function getSets()
    {
        $sets = Set::all();
        $sets = $sets->sortByDesc('releaseDate');
        $legalities = Legality::all();
        $groupedSets = $sets->groupBy('series');

        return view('sets', ['legalities' => $legalities, 'groupedSets' => $groupedSets]);
    }

    // This method retrieves a specific set's details and associated cards.
    public function getSet(Set $set, Request $request)
    {
        $order = $request->input('order');
        $sort = $request->input('sort');
        $cardsQuery = $set->cards();

        // Access the user's collection and get the card IDs in the collection.
        $userCollection = Collection::where('user_id', Auth::id())->pluck('card_id');

        // Order cards based on user-defined criteria.
        if ($order === 'name') {
            $cardsQuery->orderBy('name', $sort);
        } elseif ($order === 'rarity') {
            $cardsQuery->orderBy('rarity', $sort);
        } elseif ($order === 'number') {
            $cardsQuery->orderByRaw("CAST(number AS SIGNED) IS NULL, CAST(number AS SIGNED) $sort, number");
        } else {
            $cardsQuery->orderByRaw("CAST(number AS SIGNED) IS NULL, CAST(number AS SIGNED) $sort, number");
        }

        // Retrieve the sorted cards and add a flag to indicate if they are in the collection.
        $cards = $cardsQuery->get()->each(function ($card) use ($userCollection) {
            $card->isInCollection = $userCollection->contains($card->id);
        });

        return view('set', ['set' => $set, 'cards' => $cards, 'order' => $order, 'sort' => $sort]);
    }
}
