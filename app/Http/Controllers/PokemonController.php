<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Pokemon\Models\Pagination;
use Pokemon\Pokemon;

class PokemonController extends Controller
{
    public function __invoke()
    {
        return view('pokemon');
    }

    public function getAllCards()
    {
        $filePath = storage_path('app/all_cards.json');
        $allCardsData = json_decode(file_get_contents($filePath), true);
        if ($allCardsData === null) {
            return view('error', ['message' => 'Impossible de charger les données des cartes.']);
        }
        return view('cards', ['cards' => $allCardsData]);
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
        $response = Http::get('https://api.pokemontcg.io/v2/sets');
        $data = $response->json();
        if (isset($data['data']) && !empty($data['data'])) {
            $sets = $data['data'];
            usort($sets, function ($a, $b) {
                return strtotime($b['releaseDate']) - strtotime($a['releaseDate']);
            });
            return view('sets', ['sets' => $sets]);
        } else {
            return view('error', ['message' => 'Aucun set trouvé ou une erreur s\'est produite.']);
        }
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
