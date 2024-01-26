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
                    // Table 'set':
                    $set = Set::updateOrCreate(
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

                    // Table 'legalities':
                    Legality::updateOrCreate(
                        ['set_id' => $set->id],
                        [
                            'standard' => $cardData['set']['legalities']['standard'] ?? null,
                            'unlimited' => $cardData['set']['legalities']['unlimited'] ?? null,
                            'expanded' => $cardData['set']['legalities']['expanded'] ?? null,
                        ]
                    );

                    // Table 'card':
                    $card = Card::firstOrCreate(
                        ['name' => $cardData['name'], 'set_id' => $set->id, 'id_card' => $cardData['id']],
                        [
                            'id_card' => $cardData['id'],
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

                    // Table 'rule':
                    if (isset($cardData['rules']) && is_array($cardData['rules'])) {
                        foreach ($cardData['rules'] as $rule) {
                            Rule::firstOrCreate([
                                'rule' => $rule,
                                'card_id' => $card->id
                            ]);
                        }
                    }

                    // Table 'attack':
                    if (isset($cardData['attacks']) && is_array($cardData['attacks'])) {
                        foreach ($cardData['attacks'] as $attack) {
                            Attack::firstOrCreate(
                                ['name' => $attack['name'], 'card_id' => $card->id],
                                [
                                    'cost' => $attack['cost'],
                                    'convertedEnergyCost' => $attack['convertedEnergyCost'],
                                    'damage' => $attack['damage'],
                                    'text' => $attack['text'] ?? null,
                                ]
                            );
                        }
                    }

                    // Table 'ability':
                    if (isset($cardData['abilities']) && is_array($cardData['abilities'])) {
                        foreach ($cardData['abilities'] as $ability) {
                            Ability::firstOrCreate(
                                ['name' => $ability['name'], 'card_id' => $card->id],
                                [
                                    'text' => $ability['text'],
                                    'type' => $ability['type'],
                                ]
                            );
                        }
                    }

                    // Table 'type':
                    if (isset($cardData['types']) && is_array($cardData['types'])) {
                        foreach ($cardData['types'] as $type) {
                            Type::firstOrCreate(
                                ['type' => $type, 'card_id' => $card->id]
                            );
                        }
                    }

                    // Table 'subtype':
                    if (isset($cardData['subtypes']) && is_array($cardData['subtypes'])) {
                        foreach ($cardData['subtypes'] as $subtype) {
                            Subtype::firstOrCreate(
                                ['subtype' => $subtype, 'card_id' => $card->id]
                            );
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
        $this->info(Card::where('created_at', '>', now()->subDay())->count() . ' total new cards have been added.');

    }
}
