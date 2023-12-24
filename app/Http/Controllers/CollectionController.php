<?php

namespace App\Http\Controllers;

use App\Events\AllSetCardsCollected;
use App\Http\Requests\ModifyPatchRequest;
use App\Models\Card;
use App\Models\Collection;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use League\Csv\Writer;

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
        $collectionName = $userCollection->name ?? 'My Empty Collection';

        $groupedCards = [];
        foreach ($cardCollection as $card) {
            $setName = $card->set->name;

            // Vérifiez si le nom de l'ensemble existe déjà dans le tableau
            if (!isset($groupedCards[$setName])) {
                $groupedCards[$setName] = [];
            }

            // Ajoutez la carte au groupe correspondant
            $groupedCards[$setName][] = $card;
        }

        // Return the view with the sorted card collection
        return view('collection.index', [
            'cards' => $cardCollection,
            'collectionName' => $collectionName,
            'order' => $order,
            'sort' => $sort,
            'groupedCards' => $groupedCards,
        ]);
    }

    public function exportCollectionToCsv()
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Récupérer la collection de cartes de l'utilisateur
        $userCollection = Collection::where('user_id', $user->id)->get();

        // Créer un objet CSV
        $csv = Writer::createFromString('');

        // Ajouter l'en-tête CSV
        $csv->insertOne(['Card Name', 'Set Name', 'Card Number']);

        // Ajouter les données de chaque carte à la CSV
        foreach ($userCollection as $card) {
            $cardInfo = Card::find($card->card_id);

            // Ajouter une ligne pour chaque carte
            $csv->insertOne([
                $cardInfo->name,
                $cardInfo->set->name,
                $cardInfo->number,
            ]);
        }

        // Définir les entêtes pour la réponse
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $user->name . '\'s Collection.csv"',
        ];

        // Retourner la réponse avec le contenu CSV
        return Response::make($csv->getContent(), 200, $headers);
    }

    public function modifyNameCollection(ModifyPatchRequest $request): RedirectResponse
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get the validated data from the request
        $validatedData = $request->validated();

        // Get the new name from the validated data
        $newName = $validatedData['name'];

        // Update the user's collection name
        $userCollection = Collection::where('user_id', $user->id)->first();
        $userCollection->name = $newName;
        $userCollection->save();

        return redirect()->route('collection.index');
    }

    public function removeCard(Card $card)
    {
        $this->authorize('delete', [$card, $user = Auth::user()]);

        // Now that we have checked that the user has the card in their collection,

        // Remove the card from the user's collection
        $userCollection = Collection::where('user_id', $user->id)->where('card_id', $card->id)->first();

        if ($userCollection) {
            $userCollection->delete();
        }

        return redirect()->route('collection.index');
    }

    public function addCard(Card $card)
    {
        $this->authorize('add', [$card]);

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

        // Save the new card in the user's collection
        $userCollection->save();

        // Check if the user has collected all cards from the set
        $set = $card->set;
        $allSetCardsCollected = $user->hasAllSetCards($set);

        // If the user has collected all cards from the set, fire the event
        if ($allSetCardsCollected) {
            event(new AllSetCardsCollected($user, $set));
        }

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
