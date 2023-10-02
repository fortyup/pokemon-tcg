@extends('master')

@section('meta')
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Maxime Capel">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <title>Pokemon</title>

    <!-- Afficher les données à partir de la fonction getCard(id) -->
    <div class="">
        <div class="flex">
            <div>
                <!-- Faire en sorte que l'image soit à 20% de sa taille originale -->
                <img src="{{ $card['images']['large'] }}" alt="{{ $card['name'] }}"
                     style="box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.45);" class="max-w-xs rounded-2xl">
            </div>
            <div class="p-3 ml-40">
                <section>
                    <div class="flex flex-row justify-between">
                        <div class="flex-column">
                            <h2 class="text-4xl font-bold">{{ $card['name'] }}</h2>
                            <p class="text-2xl">{{ $card['supertype'] }} - {{ implode(', ', $card['subtypes']) }}</p>
                        </div>
                        <div class="flex flex-row items-center">
                            <!-- Si la carte n'a pas de points de vie, ne pas afficher sinon afficher les points de vie -->
                            @if(isset($card['hp']))
                                <p class="text-2xl mr-2">HP {{ $card['hp'] }}</p>
                            @endif
                            @if(
                                isset($card['types']) &&
                                is_array($card['types']) &&
                                count($card['types']) > 0
                            )
                                @foreach($card['types'] as $type)
                                    <img src="{{ asset('/images/type/'.$type.'.png') }}" alt="{{ $type }}"
                                         class="h-6 w-6 mr-1">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </section>
                <hr style="background-color: #d3d3d3;" class="block h-0.5 m-6 mx-0">
                <!-- Si le pokemon a une capacité en [0], l'afficher avec son type, son nom et son texte pareil pour une capacité en [1] sinon ne rienn afficher -->
                <section>
                @if(isset($card['abilities']) && is_array($card['abilities']) && count($card['abilities']) > 0)
                        <h2 class="uppercase mb-2">Abilities:</h2>
                        <div class="mb-5">
                        @foreach($card['abilities'] as $ability)
                                <div class="flex">
                                    <!-- si l'abilité = pokémon power alors ne rien afficher -->
                                    @if($ability['type'] != 'Pokémon Power')
                                        <img src="{{ asset('/images/ability/'.$ability['type'].'.png') }}"
                                             class="w-24 h-auto" alt="{{ $ability['type'] }}">
                                        <p class="text-2xl ml-2">{{ $ability['name'] }}</p>
                                    @else
                                        <p class="text-2xl">{{ $ability['name'] }}</p>
                                    @endif
                            </div>
                                <p>{{ $ability['text'] }}</p>
                        @endforeach
                        </div>
                @endif
                </section>
                <!-- Section pour afficher les attaques du pokémon. Si le pokémon n'a pas d'attaque, ne rien afficher. Sinon afficher les attaques -->
                <section>
                    @if(isset($card['attacks']) && is_array($card['attacks']) && count($card['attacks']) > 0)
                        <h2 class="uppercase mb-2">Attacks:</h2>
                        <div class="mb-5">
                            @if(isset($card['attacks']) && is_array($card['attacks']) && count($card['attacks']) > 0)
                                @foreach($card['attacks'] as $attack)
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            @if(isset($attack['cost']) && is_array($attack['cost']) && count($attack['cost']) > 0)
                                                @foreach($attack['cost'] as $cost)
                                                    @if(isset($attack['cost']) && is_array($attack['cost']) && count($attack['cost']) > 0)
                                                        <img src="{{ asset('/images/type/'.$cost.'.png') }}"
                                                             alt="{{ $cost }}" class="h-6 w-6 mr-1">
                                                @endif
                                                @endforeach
                                            @endif
                                            <h2 class="text-2xl ml-2">{{ $attack['name'] }}</h2>
                                        </div>
                                        <div>
                                            <p>{{ $attack['damage'] }}</p>
                                        </div>
                                    </div>
                                    <p>{{ $attack['text'] }}</p>
                                @endforeach
                            @endif
                        </div>
                    @endif
                </section>

                <!-- Une carte peut avoir plusieurs règles. Afficher toutes les règles -->
                <section>
                    @if(isset($card['rules']) && is_array($card['rules']) && count($card['rules']) > 0)
                        <h2 class="uppercase mb-2">Rules:</h2>
                            @foreach($card['rules'] as $rule)
                            <p class="mb-2">{{ $rule }}</p>
                            @endforeach
                    @endif
                </section>
                <!-- Si la carte a une faiblesse, afficher l'image du type -->
                <section>
                    <div class="grid grid-cols-3 gap-4 mt-5">
                        <div>
                            @if(isset($card['weaknesses']) && is_array($card['weaknesses']) && count($card['weaknesses']) > 0)
                                <h2 class="uppercase mb-2">Weakness:</h2>
                                @foreach($card['weaknesses'] as $weaknesses)
                                    <div class="flex flex-row items-center font-bold">
                                        <img src="{{ asset('/images/type/'.$weaknesses['type'].'.png') }}"
                                             alt="{{ $weaknesses['type'] }}" class="w-6 h-auto">
                                        <p class="ml-2">{{ $weaknesses['value'] }}</p>
                                    </div>
                            @endforeach
                            @else
                                <h2 class="uppercase mb-2">Weakness:</h2>
                                <p class="font-bold">N/A</p>
                            @endif
                        </div>

                        <div>
                            <!-- Si la carte n'a pas de résistance, afficher N/A sinon afficher la valeur -->
                            @if(isset($card['resistances']) && is_array($card['resistances']) && count($card['resistances']) > 0)
                                <h2 class="uppercase mb-2">Resistance:</h2>
                            @foreach($card['resistances'] as $resistance)
                                    <div class="flex flex-row items-center font-bold">
                                        <img src="{{ asset('/images/type/'.$resistance['type'].'.png') }}"
                                             alt="{{ $resistance['type'] }}" class="w-6 h-auto">
                                        <p class="ml-2">Value: {{ $resistance['value'] }}</p>
                                    </div>
                            @endforeach
                            @else
                                <h2 class="uppercase mb-2">Resistance:</h2>
                                <p class="font-bold">N/A</p>
                            @endif
                        </div>

                        <div>
                            <!-- Afficher tous les coûts de retraite du pokémon. Si le pokémon n'a pas de coût de retraite, afficher N/A -->
                            @if(isset($card['retreatCost']) && is_array($card['retreatCost']) && count($card['retreatCost']) > 0)
                                <h2 class="uppercase mb-2">Retreat cost:</h2>
                                <div class="flex flex-row">
                                    @foreach($card['retreatCost'] as $retreatCost)
                                        <img src="{{ asset('/images/type/'.$retreatCost.'.png') }}"
                                             alt="{{ $retreatCost }}"
                                             class="h-6 w-6 mr-1">
                                    @endforeach
                                </div>
                            @else
                                <h2 class="uppercase mb-2">Retreat cost:</h2>
                                <p class="font-bold">N/A</p>
                            @endif
                        </div>

                        <div>
                            <!-- Afficher la rareté de la carte -->
                            <h2 class="uppercase mb-2">Rarity:</h2>
                            <p class="font-bold">{{ $card['rarity'] }}</p>
                        </div>

                        <div>
                            <!-- Afficher le numéro de la carte dans la série ex: 1 / 146 -->
                            <h2 class="uppercase mb-2">Serial number:</h2>
                            <p class="font-bold">{{ $card['number'] }} / {{ $card['set']['printedTotal'] }}</p>
                        </div>

                        <div>
                            <!-- Afficher le nom de l'extension de la carte ainsi que le symbole de l'extension -->
                            <h2 class="uppercase mb-2">Set:</h2>
                            <a href="{{ route('set', ['id' => $card['set']['id']]) }}"
                               class="flex flex-row items-center font-bold">
                                <p class="mr-2">{{ $card['set']['name'] }}</p>
                                <img src="{{ $card['set']['images']['symbol'] }}" alt="{{ $card['set']['name'] }}"
                                     class="w-6 h-auto">
                        </a>
                        </div>
                    </div>
                </section>
            </div>
    </div>
@endsection
