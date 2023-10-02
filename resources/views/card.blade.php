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
                     style="max-width:310px; border-radius: 20px; box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.45);">
            </div>
            <div class="" style="padding: 0.75rem; margin-left: 8%">
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
                                         style="width: 25px; height: 25px">
                                @endforeach
                            @endif
                        </div>
                    </div>
                </section>
                <hr style="display: block;height: 2px;margin: 1.5rem 0;background-color: #d3d3d3;">
                <!-- Si le pokemon a une capacité en [0], l'afficher avec son type, son nom et son texte pareil pour une capacité en [1] sinon ne rienn afficher -->
                <section>
                @if(isset($card['abilities']) && is_array($card['abilities']) && count($card['abilities']) > 0)
                        <h2 class="uppercase mb-2">Abilities:</h2>
                    <ul>
                        @foreach($card['abilities'] as $ability)
                            <div class="flex flex-row mb-1">
                                <img src="{{ asset('/images/ability/'.$ability['type'].'.png') }}"
                                     style="width: 100px; height: auto" alt="{{ $ability['type'] }}">
                                <p class="text-2xl">{{ $ability['name'] }}</p>
                            </div>
                            <p class="mb-5">{{ $ability['text'] }}</p>
                        @endforeach
                    </ul>
                @endif
                </section>
                <!-- Section pour afficher les attaques du pokémon. Si le pokémon n'a pas d'attaque, ne rien afficher. Sinon afficher les attaques -->
                <section>
                    @if(isset($card['attacks']) && is_array($card['attacks']) && count($card['attacks']) > 0)
                        <h2 class="uppercase mb-2">Attacks:</h2>

                    <div class="flex flex-row items-center justify-between">
                        <div class="flex flex-row items-center">
                            @if(isset($card['attacks']) && is_array($card['attacks']) && count($card['attacks']) > 0)
                        @foreach($card['attacks'] as $attack)
                            <!-- Si le pokemon a plusieurs coûts d'attaque, les afficher. Sinon n'afficher que le premier -->
                                    <div class="flex flex-row">
                            @if(isset($attack['cost']) && is_array($attack['cost']) && count($attack['cost']) > 0)
                                    @foreach($attack['cost'] as $cost)
                                    @if(isset($attack['cost']) && is_array($attack['cost']) && count($attack['cost']) > 0)
                                        <img src="{{ asset('/images/type/'.$cost.'.png') }}" alt="{{ $cost }}"
                                             style="width: 25px; height: 25px">
                                                @endif
                                    @endforeach
                                            <p class="text-2xl ml-1">{{ $attack['name'] }}</p>
                                    </div>
                            @endif
                                    <p class="text-2xl">{{ $attack['damage'] }}</p>
                                    <p>{{ $attack['text'] }}</p>
                        </div>
                    </div>
                        @endforeach
                    @endif
                        @endif
                </section>
                    <!-- Une carte peut avoir plusieurs règles. Afficher toutes les règles -->
                <section>
                    @if(isset($card['rules']) && is_array($card['rules']) && count($card['rules']) > 0)
                        <h2 class="uppercase mb-2 mt-5">Rules:</h2>
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
                                <h2 class="uppercase mb2">Weakness:</h2>
                                @foreach($card['weaknesses'] as $weaknesses)
                                    <div class="flex flex-row items-center font-bold">
                                        <img src="{{ asset('/images/type/'.$weaknesses['type'].'.png') }}"
                                             alt="{{ $weaknesses['type'] }}" style="width: 25px;">
                                        <p>{{ $weaknesses['value'] }}</p>
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
                                             alt="{{ $resistance['type'] }}" style="width: 25px;">
                                        <p>Value: {{ $resistance['value'] }}</p>
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
                                             style="width: 25px; height: 25px">
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
                                     style="width: 25px;">
                        </a>
                        </div>
                    </div>
                </section>
            </div>
    </div>
@endsection
