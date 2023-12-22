<?php

namespace App\Console\Commands;

use App\Models\Ability;
use App\Models\Attack;
use App\Models\Card;
use App\Models\Legality;
use App\Models\Rule;
use App\Models\Set;
use App\Models\Subtype;
use App\Models\Type;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchPokemonCards extends Command
{
    protected $signature = 'fetch:pokemon-cards';

    protected $description = 'Fetch and store Pokemon data from the API';

    public function handle(): void
    {
        $pageSize = 250;
        $page = 1;

        do {
            $response = Http::get("https://api.pokemontcg.io/v2/cards", [
                'pageSize' => $pageSize,
                'page' => $page,
            ]);

            $data = $response->json();

            if (isset($data['data'])) {
                foreach ($data['data'] as $cardData) {
                    // Table 'sets':
                    $set = Set::firstOrNew(
                        ['id_set' => $cardData['set']['id']],
                        [
                            'name' => $cardData['set']['name'],
                            'series' => $cardData['set']['series'],
                            'printedTotal' => $cardData['set']['printedTotal'],
                            'total' => $cardData['set']['total'],
                            'ptcgoCode' => $cardData['set']['ptcgoCode'] ?? null,
                            'releaseDate' => $cardData['set']['releaseDate'],
                            'updatedAt' => $cardData['set']['updatedAt'],
                            'symbol' => $cardData['set']['images']['symbol'],
                            'logo' => $cardData['set']['images']['logo']
                        ]
                    );

                    if (!$set->exists) {
                        $set->save();
                    }

                    // Table 'legalities':
                    $legality = Legality::firstOrNew(
                        ['set_id' => $set->id],
                        [
                            'standard' => $cardData['set']['legalities']['standard'] ?? null,
                            'unlimited' => $cardData['set']['legalities']['unlimited'] ?? null,
                            'expanded' => $cardData['set']['legalities']['expanded'] ?? null,
                        ]
                    );

                    if (!$legality->exists) {
                        $legality->save();
                    }

                    // Table 'cards':
                    $card = Card::firstOrNew(
                        ['id_card' => $cardData['id']],
                        [
                            'name' => $cardData['name'],
                            'supertype' => $cardData['supertype'],
                            'hp' => $cardData['hp'] ?? null,
                            'flavorText' => $cardData['flavorText'] ?? null,
                            'number' => $cardData['number'] ?? null,
                            'artist' => $cardData['artist'] ?? null,
                            'rarity' => $cardData['rarity'] ?? null,
                            'smallImage' => $cardData['images']['small'] ?? null,
                            'largeImage' => $cardData['images']['large'] ?? null,
                            'typeWeakness' => $cardData['weaknesses'][0]['type'] ?? null,
                            'valueWeakness' => $cardData['weaknesses'][0]['value'] ?? null,
                            'typeResistance' => $cardData['resistances'][0]['type'] ?? null,
                            'valueResistance' => $cardData['resistances'][0]['value'] ?? null,
                            'retreatCost' => $cardData['retreatCost'] ?? null,
                            'convertedRetreatCost' => $cardData['convertedRetreatCost'] ?? null,
                            'set_id' => $set->id,
                        ]
                    );

                    if (!$card->exists) {
                        $card->save();
                    }

                    // Table 'rules':
                    if (isset($cardData['rules']) && is_array($cardData['rules'])) {
                        foreach ($cardData['rules'] as $rule) {
                            Rule::create([
                                'rule' => $rule,
                                'card_id' => $card->id,
                            ]);
                        }
                    }

                    // Table 'attacks':
                    if (isset($cardData['attacks']) && is_array($cardData['attacks'])) {
                        foreach ($cardData['attacks'] as $attacks) {
                            Attack::create([
                                'name' => $attacks['name'],
                                'cost' => $attacks['cost'],
                                'convertedEnergyCost' => $attacks['convertedEnergyCost'],
                                'damage' => $attacks['damage'],
                                'text' => $attacks['text'] ?? null,
                                'card_id' => $card->id,
                            ]);
                        }
                    }

                    // Table 'abilities':
                    if (isset($cardData['abilities']) && is_array($cardData['abilities'])) {
                        foreach ($cardData['abilities'] as $ability) {
                            Ability::create([
                                'name' => $ability['name'],
                                'text' => $ability['text'],
                                'type' => $ability['type'],
                                'card_id' => $card->id,
                            ]);
                        }
                    }

                    // Table 'types':
                    if (isset($cardData['types']) && is_array($cardData['types'])) {
                        foreach ($cardData['types'] as $type) {
                            Type::create([
                                'type' => $type,
                                'card_id' => $card->id,
                            ]);
                        }
                    }

                    // Table 'subtypes':
                    if (isset($cardData['subtypes']) && is_array($cardData['subtypes'])) {
                        foreach ($cardData['subtypes'] as $subtype) {
                            Subtype::create([
                                'subtype' => $subtype,
                                'card_id' => $card->id,
                            ]);
                        }
                    }
                }
                $this->info('Page ' . $page . ' done.');
                $page++;
            } else {
                break;
            }
        } while (isset($data['data']) && count($data['data']) === $pageSize);

        $this->info('Pokemon data have been fetched and stored in the database.');
        $this->info(Card::where('created_at', '>', now()->subDay())->count() . ' new cards have been added.');
    }
}
