<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchPokemonCards extends Command
{
    protected $signature = 'fetch:pokemon-cards';

    protected $description = 'Fetch and store all Pokemon cards from the API';

    public function handle()
    {
        $pageSize = 250;
        $page = 1;
        $allCards = [];

        do {
            $response = Http::get("https://api.pokemontcg.io/v2/cards", [
                'pageSize' => $pageSize,
                'page' => $page,
            ]);

            $data = $response->json();

            if (isset($data['data'])) {
                foreach ($data['data'] as $card) {
                    if (!$this->cardExists($allCards, $card)) {
                        $allCards[] = $card;
                    }
                }

                $page++;
            } else {
                break;
            }
        } while (isset($data['data']) && count($data['data']) === $pageSize);

        // Save $allCards to a JSON file
        file_put_contents('all_cards.json', json_encode($allCards, JSON_PRETTY_PRINT));

        $this->info('All Pokemon cards have been fetched and stored in all_cards.json.');
    }

    private function cardExists(array $cards, array $targetCard)
    {
        foreach ($cards as $card) {
            if ($card['id'] === $targetCard['id']) {
                return true;
            }
        }
        return false;
    }

}
