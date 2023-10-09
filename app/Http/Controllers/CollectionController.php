<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    // This method displays the user's card collection.
    public function showCollection()
    {
        $user = Auth::user();

        // Retrieve the user's collection of cards.
        $userCollection = Collection::where('user_id', $user->id)->get();
        $cardCollection = [];

        // For each card in the user's collection, retrieve card information.
        foreach ($userCollection as $card) {
            $cardInfo = Card::where('id', $card->card_id)->first();
            array_push($cardCollection, $cardInfo);
        }

        // Return the view with the user's card collection.
        return view('collection.index', [
            'cards' => $cardCollection
        ]);
    }

    // This method removes a card from the user's collection.
    public function removeCard(Card $card)
    {
        $user = Auth::user();

        // Find the user's collection item for the specified card.
        $userCollection = Collection::where('user_id', $user->id)->where('card_id', $card->id)->first();

        // Delete the collection item.
        $userCollection->delete();

        // Redirect to the collection index.
        return redirect()->route('collection.index');
    }

    // This method adds a card to the user's collection.
    public function addCard(Card $card)
    {
        $user = Auth::user();

        // Check if the user already has the card in their collection.
        $userCollection = Collection::where('user_id', $user->id)->where('card_id', $card->id)->first();

        // If the user already has the card, redirect back to the collection.
        if ($userCollection) {
            return redirect()->route('collection.index');
        }

        // Create a new collection item and save it.
        $userCollection = new Collection();
        $userCollection->user_id = $user->id;
        $userCollection->card_id = $card->id;
        $userCollection->save();

        // Redirect to the collection index.
        return redirect()->route('collection.index');
    }
}
