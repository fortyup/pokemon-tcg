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

    private const API_URL = 'https://api.pokemontcg.io/v2/cards';
    private const PAGE_SIZE = 250;

    public function handle(): void
    {
        $page = 1;

        do {
            $response = Http::get(self::API_URL, [
                'pageSize' => self::PAGE_SIZE,
                'page' => $page,
            ]);

            $data = $response->json();

            $page = $this->processFetchedData($data, $page);

        } while (isset($data['data']) && count($data['data']) === self::PAGE_SIZE);

        $this->info('Pokemon data have been fetched and stored in the database.');
        $this->info(Card::where('created_at', '>', now()->subDay())->count() . ' total new cards have been added.');

    }

    private function processFetchedData($data, $page)
    {

        if (isset($data['data'])) {
            foreach ($data['data'] as $cardData) {
                $set = $this->processSetData($cardData);
                $this->processLegalitiesData($set, $cardData);
                $card = $this->processCardData($set, $cardData);
                $this->processRuleData($card, $cardData);
                $this->processAttackData($card, $cardData);
                $this->processAbilityData($card, $cardData);
                $this->processTypeData($card, $cardData);
                $this->processSubtypeData($card, $cardData);
            }
            $this->info('Page ' . $page . ' done.');
            $page++;
        }

        return $page;
    }

    // Process set data
    private function processSetData($cardData): Set
    {
        return Set::updateOrCreate(
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

    }

    // Process legalities data
    private function processLegalitiesData($set, $cardData): void
    {
        Legality::updateOrCreate(
            ['set_id' => $set->id],
            [
                'standard' => $cardData['set']['legalities']['standard'] ?? null,
                'unlimited' => $cardData['set']['legalities']['unlimited'] ?? null,
                'expanded' => $cardData['set']['legalities']['expanded'] ?? null,
            ]
        );
    }

    // Process card data
    private function processCardData($set, $cardData): Card
    {
        return Card::firstOrCreate(
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

    }

    // Process rule data
    private function processRuleData($card, $cardData): void
    {
        if (isset($cardData['rules']) && is_array($cardData['rules'])) {
            foreach ($cardData['rules'] as $rule) {
                Rule::firstOrCreate([
                    'rule' => $rule,
                    'card_id' => $card->id
                ]);
            }
        }
    }

    // Process attack data
    private function processAttackData($card, $cardData): void
    {
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
    }

    // Process ability data
    private function processAbilityData($card, $cardData): void
    {
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
    }

    // Process type data
    private function processTypeData($card, $cardData): void
    {
        if (isset($cardData['types']) && is_array($cardData['types'])) {
            foreach ($cardData['types'] as $type) {
                Type::firstOrCreate(
                    [
                        'type' => $type,
                        'card_id' => $card->id
                    ]
                );
            }
        }
    }

    // Process subtype data
    private function processSubtypeData($card, $cardData): void
    {
        if (isset($cardData['subtypes']) && is_array($cardData['subtypes'])) {
            foreach ($cardData['subtypes'] as $subtype) {
                Subtype::firstOrCreate(
                    [
                        'subtype' => $subtype,
                        'card_id' => $card->id
                    ]
                );
            }
        }
    }
}
