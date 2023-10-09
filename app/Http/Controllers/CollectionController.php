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

    public function removeCard(Card $card)
    {
        $user = Auth::user();

        $userCollection = Collection::where('user_id', $user->id)->where('card_id', $card->id)->first();
        $userCollection->delete();

        return redirect()->route('collection.index');
    }

    public function addCard(Card $card)
    {
        $user = Auth::user();

        $userCollection = Collection::where('user_id', $user->id)->where('card_id', $card->id)->first();

        if ($userCollection) {
            return redirect()->route('collection.index');
        }

        $userCollection = new Collection();
        $userCollection->user_id = $user->id;
        $userCollection->card_id = $card->id;
        $userCollection->save();

        return redirect()->route('collection.index');
    }
}
