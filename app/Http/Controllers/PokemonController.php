<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Legality;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function __invoke()
    {
        return view('pokemon');
    }

    public function getAllCards()
    {
        $cards = Card::all();
        // Récupération du nom et des id_set des sets
        $sets = Set::all();
        return view('cards', ['cards' => $cards, 'sets' => $sets]);
    }

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

    public function getSets()
    {
        $sets = Set::all();
        $sets = $sets->sortByDesc('releaseDate');
        $legalities = Legality::all();
        return view('sets', ['sets' => $sets, 'legalities' => $legalities]);
    }

    public function getSet(Set $set, Request $request)
    {
        $cards = $set->cards;

        return view('set', [
            'set' => $set,
            'cards' => $cards]);
    }

    public function getError()
    {
        return view('error', ['message' => 'Une erreur est survenue.']);
    }

}
