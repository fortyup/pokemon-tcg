<?php

namespace App\Http\Controllers;

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

    public function getCard($id)
    {
        $response = Pokemon::Card()->find($id);
        return view('card', ['card' => $response->toArray()]);
    }

    public function getError()
    {
        return view('error', ['message' => 'Une erreur est survenue.']);
    }

}
