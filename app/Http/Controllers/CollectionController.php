<?php

namespace App\Http\Controllers;

use App\Events\AllSetCardsCollected;
use App\Models\Card;
use App\Models\Collection;
use App\Models\Set;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function showCollection(Request $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get sorting parameters from the request
        $order = $request->input('order', 'set');
        $sort = $request->input('sort', 'Desc');

        // Retrieve the user's card collection
        $userCollection = Collection::where('user_id', $user->id)->get();
        $cardCollection = [];

        // For each card in the user's collection, fetch card information
        foreach ($userCollection as $card) {
            $cardInfo = Card::where('id', $card->card_id)->first();
            array_push($cardCollection, $cardInfo);
        }

        // Sort the collection using the custom sorting function
        usort($cardCollection, function ($a, $b) use ($order, $sort) {
            if ($sort == 'Asc') {
                if ($a->set->name == $b->set->name) {
                    return $a->number > $b->number;
                }
                return $a->$order > $b->$order;
            } else {
                if ($a->set->name == $b->set->name) {
                    return $a->number < $b->number;
                }
                return $a->$order < $b->$order;
            }
        });
        // Get the user's collection name
        $userCollection = Collection::where('user_id', $user->id)->first();
        $collectionName = $userCollection->name;

        // Check if the user has collected all the cards of a set
        $sets = Set::all();
        foreach ($sets as $set) {
            if ($user->hasAllSetCards($set)) {
                // Dispatch an event to send an email to the user
                event(new AllSetCardsCollected($user, $set));
            }
        }

        // Return the view with the sorted card collection
        return view('collection.index', [
            'cards' => $cardCollection,
            'collectionName' => $collectionName,
            'order' => $order,
            'sort' => $sort
        ]);
    }

    public function modifyNameCollection(Request $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get the new name of the collection
        $newName = $request->input('name');

        // Update the name of the collection
        $userCollection = Collection::where('user_id', $user->id)->first();
        $userCollection->name = $newName;
        $userCollection->save();

        return redirect()->route('collection.index');
    }

    public function removeCard(Card $card)
    {
        $user = Auth::user();

        // Get the user's card from the collection
        $userCollection = Collection::where('user_id', $user->id)->where('card_id', $card->id)->first();

        if ($userCollection) {
            // Delete the card from the collection
            $userCollection->delete();
        }

        return redirect()->route('collection.index');
    }

    public function addCard(Card $card)
    {
        $user = Auth::user();

        // Check if the card is already in the user's collection
        $userCollection = Collection::where('user_id', $user->id)->where('card_id', $card->id)->first();

        if ($userCollection) {
            // Redirect if the card is already in the collection
            return redirect()->route('collection.index');
        }

        // Add the card to the user's collection
        $userCollection = new Collection();
        $userCollection->user_id = $user->id;
        $userCollection->card_id = $card->id;
        $userCollection->save();

        return redirect()->route('collection.index');
    }

    public function showCollectionOtherUsers()
    {
        // Get the currently authenticated user
        $currentUser = Auth::user();

        // Paginate the list of users to avoid a large number of results
        $users = User::where('id', '!=', $currentUser->id)->paginate(3);

        $cardCollections = [];

        // For each user, fetch their card collection
        foreach ($users as $user) {
            $userCollection = Collection::where('user_id', $user->id)->get();
            $cardCollection = [];

            // For each card in the user's collection, fetch card information
            foreach ($userCollection as $card) {
                $cardInfo = Card::where('id', $card->card_id)->first();
                array_push($cardCollection, $cardInfo);
            }

            // Associate the card collection with the user (name and id)
            $cardCollections[$user->id] = [
                'name' => $user->name,
                'cards' => $cardCollection,
            ];
        }

        // Return the view with collections of cards for other users
        return view('users.index', [
            'collections' => $cardCollections,
            'users' => $users,
        ]);
    }

    // Method to show the collection of a specific user based on their id
    public function showCollectionOtherUsersId($id)
    {
        // Get the user with the specified id
        $user = User::where('id', $id)->first();

        // Get the user's card collection
        $userCollection = Collection::where('user_id', $user->id)->get();
        $cardCollection = [];

        // For each card in the user's collection, fetch card information
        foreach ($userCollection as $card) {
            $cardInfo = Card::where('id', $card->card_id)->first();
            array_push($cardCollection, $cardInfo);
        }

        // Return the view with the user's card collection
        return view('users.show', [
            'cards' => $cardCollection,
            'user' => $user,
        ]);
    }
}
