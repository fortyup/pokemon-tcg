<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{

    public function showCollection()
    {
        $user = Auth::user();

        $userCollection = Collection::where('user_id', $user->id)->get();
        $cardCollection = [];

        foreach ($userCollection as $card) {
            $cardInfo = Card::where('id', $card->card_id)->first();
            array_push($cardCollection, $cardInfo);
        }

        return view('collection.index', [
            'cards' => $cardCollection
        ]);
    }
}
