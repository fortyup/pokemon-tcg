<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Collection;
use App\Models\Legality;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class PokemonController extends Controller
{
    // This method returns the default view for the controller.
    public function __invoke()
    {
        return view('pokemon');
    }

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

    // This method retrieves a list of all sets.
    public function getSets()
    {
        $sets = Set::all();
        $sets = $sets->sortByDesc('releaseDate');
        $legalities = Legality::all();

        return view('sets', ['sets' => $sets, 'legalities' => $legalities]);
    }

    // This method retrieves a specific set's details and associated cards.
    public function getSet(Set $set, Request $request)
    {
        $order = $request->input('order');
        $sort = $request->input('sort');
        $cardsQuery = $set->cards();

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

        // Retrieve the sorted cards.
        $cards = $cardsQuery->get();

        return view('set', ['set' => $set, 'cards' => $cards, 'order' => $order, 'sort' => $sort]);
    }

    // This method displays an error view with a specified message.
    public function getError()
    {
        return view('error', ['message' => 'Une erreur est survenue.']);
    }
}
