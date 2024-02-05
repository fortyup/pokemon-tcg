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

const COLLECTION_INDEX = 'collection.index';

class CollectionController extends Controller
{
    public function showCollection(Request $request)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get sorting parameters from the request
        $order = $request->input('order', 'set');
        $sort = $request->input('sort', 'Desc');

        // Retrieve the user's card collection with relationships
        $cardCollection = $user->collections()->with('card.set')->get()->pluck('card');

        // Sort the collection
        $cardCollection = $this->sortCardCollection($cardCollection, $order, $sort);

        // Group the cards by set
        $groupedCards = $this->groupCardsBySet($cardCollection);

        // Get the user's collection name
        $collectionName = $user->collections()->value('name') ?? 'My Empty Collection';

        $set = $request->input('set', null);

        // Return the view with the sorted card collection
        return view(COLLECTION_INDEX, [
            'cards' => $cardCollection,
            'collectionName' => $collectionName,
            'order' => $order,
            'sort' => $sort,
            'groupedCards' => $groupedCards,
            'set' => $set,
        ]);
    }

    private function sortCardCollection($cardCollection, $order, $sort)
    {
        if ($order == 'set') {
            $order = 'set.releaseDate';
        } elseif ($order == 'name') {
            $order = 'set.name';
        } else {
            $order = 'number';
        }

        if ($sort == 'Desc') {
            $cardCollection = $cardCollection->sortByDesc($order);
        } else {
            $cardCollection = $cardCollection->sortBy($order);
        }

        return $cardCollection;
    }

    private function groupCardsBySet($cardCollection)
    {
        return $cardCollection->groupBy('set.name')->map(function ($group) {
            return $group->sortByDesc('number');
        });
    }


    public function exportCollectionToCsv()
    {
        // Récupérer l'utilisateur actuellement authentifié
        $user = Auth::user();

        // Récupérer la collection de cartes de l'utilisateur
        $userCollection = Collection::where('user_id', $user->id)->get();

        // Créer un objet CSV
        $csv = Writer::createFromFileObject(new \SplTempFileObject());

        // Ajouter l'en-tête CSV
        $csv->insertOne(['Card Name', 'Set Name', 'Rarity', 'Number']);
        // Ajouter les données de chaque carte à la CSV
        foreach ($userCollection as $card) {
            $cardInfo = Card::find($card->card_id);

            // Ajouter une ligne pour chaque carte
            $csv->insertOne([
                $cardInfo->name,
                $cardInfo->set->name,
                $cardInfo->rarity,
                sprintf('%03d', $cardInfo->number) . '/' . sprintf('%03d', $cardInfo->set->cards->count())
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
        $user->collections()->update(['name' => $newName]);

        return redirect()->route(COLLECTION_INDEX);
    }

    public function removeCard(Card $card)
    {
        $this->authorize('delete', [$card, $user = Auth::user()]);

        // Retirer la carte de la collection de l'utilisateur
        $user->collections()->where('card_id', $card->id)->delete();

        return redirect()->route(COLLECTION_INDEX);
    }

    public function addCard(Card $card)
    {
        $this->authorize('add', [$card]);

        $user = Auth::user();

        // Vérifier si la carte est déjà dans la collection de l'utilisateur
        if ($user->collections()->where('card_id', $card->id)->exists()) {
            // Rediriger si la carte est déjà dans la collection
            return redirect()->route(COLLECTION_INDEX);
        }

        // Ajouter la carte à la collection de l'utilisateur
        $user->collections()->create(['card_id' => $card->id]);

        // Vérifier si l'utilisateur a collecté toutes les cartes de l'ensemble
        $set = $card->set;
        $allSetCardsCollected = $user->hasAllSetCards($set);

        // Si l'utilisateur a collecté toutes les cartes de l'ensemble, déclencher l'événement
        if ($allSetCardsCollected) {
            event(new AllSetCardsCollected($user, $set));
        }

        return redirect()->route(COLLECTION_INDEX);
    }

    public function showCollectionOtherUsers()
    {
        // Get the currently authenticated user
        $currentUser = Auth::user();

        // Paginate the list of users to avoid a large number of results
        $users = User::where('id', '!=', $currentUser->id)->paginate(10);

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

        // Group the cards by set
        $groupedCards = collect($cardCollection)->groupBy('set.name');

        // Return the view with the user's card collection grouped by set
        return view('users.show', [
            'groupedCards' => $groupedCards,
            'user' => $user,
        ]);
    }
}
