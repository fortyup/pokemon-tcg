<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Legality;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $cards = $query->get();
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

        return view('card', [
            'card' => $card,
            'set' => $set,
            'subtypes' => $subtypes,
            'types' => $types,
            'attacks' => $attacks,
            'rules' => $rules,
            'abilities' => $abilities
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
            // If the criteria is 'number,' order numerically; otherwise, order by default.
            $cardsQuery->orderByRaw('CAST(number AS UNSIGNED) ' . $sort);
        } else {
            $cardsQuery->orderByRaw('CAST(number AS UNSIGNED) ' . $sort);
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
