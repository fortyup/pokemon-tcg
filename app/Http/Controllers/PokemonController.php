<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Pokemon\Pokemon;

class PokemonController extends Controller
{
    public function __invoke()
    {
        return view('pokemon');
    }

    public function getPagination()
    {
        /* @var Pagination $response */
        $response = Pokemon::Card()->pagination();
        return view('cards', ['pagination' => $response->toArray()]);
    }

    public function getAllCards()
    {
        $response = Pokemon::Card()->all();
        foreach ($response as $model) {
            $cards[] = $model->toArray();
        }
        return view('cards', ['cards' => $cards]);
    }

    public function getCard($id)
    {
        $response = Pokemon::Card()->find($id);
        return view('card', ['card' => $response->toArray()]);

    }
}
