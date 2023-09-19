<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function __invoke()
    {
        return view('pokemon');
    }

    public function getCards()
    {
        // Faire une requête à l'API pour récupérer l'ensemble des cartes'
        $response = Http::get('https://api.pokemontcg.io/v2/cards');
        // Récupérer les données de la réponse
        $data = $response->json();
        // Retourner la vue "cards" en lui passant les données des cartes
        return view('cards', ['cards' => $data['data']]);
    }

    public function getCard($id)
    {
        // Faire une requête à l'API pour récupérer les données de la carte dont l'id est passé en paramètre de la route (ex: cards/xy7-54)
        $response = Http::get('https://api.pokemontcg.io/v2/cards/' .$id);
        // Récupérer les données de la réponse
        $data = $response->json();
        // Retourner la vue "card" en lui passant les données de la carte
        return view('card', ['card' => $data['data']]);
    }
}
