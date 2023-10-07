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
                <img src="{{ $card->largeImage }}" alt="{{ $card->name }}" class="max-w-md rounded-3xl">
            </div>
            <div class="p-3 ml-40">
                <section>
                    <div class="flex flex-row justify-between">
                        <div class="flex-column">
                            <h2 class="text-4xl font-bold">{{ $card->name }}</h2>
                            <p class="text-2xl">{{ $card->supertype }}
                                - {{ $subtypes->pluck('subtype')->implode(',') }}</p>
                        </div>
                        <div class="flex flex-row items-center">
                            <!-- Si la carte n'a pas de points de vie, ne pas afficher sinon afficher les points de vie -->
                            @if($card->hp != null)
                                <p class="text-2xl mr-2">HP {{ $card->hp }}</p>
                            @endif
                            @foreach($types as $type)
                                <img src="{{ asset('/images/type/'.$type->type.'.png') }}" alt="{{ $type->type }}"
                                         class="h-6 w-6 mr-1">
                                @endforeach
                        </div>
                    </div>
                </section>
                <hr style="background-color: #d3d3d3;" class="block h-0.5 m-6 mx-0">
                <!-- Si le pokemon a une capacité en [0], l'afficher avec son type, son nom et son texte pareil pour une capacité en [1] sinon ne rienn afficher -->
                <section>
                    <!-- s'il n'y a pas d'abilité, ne rien afficher -->
                    @if($abilities->count() > 0)
                        <h2 class="uppercase mb-2">Abilities:</h2>
                        <div class="mb-5">
                            @foreach($abilities as $ability)
                                <div class="flex">
                                    <!-- si l'abilité = pokémon power alors ne rien afficher -->
                                    @if($ability->type != 'Pokémon Power')
                                        <img src="{{ asset('/images/ability/'.$ability->type.'.png') }}"
                                             class="w-24 h-auto" alt="{{ $ability->type }}">
                                        <p class="text-2xl ml-2">{{ $ability->name }}</p>
                                    @else
                                        <p class="text-2xl">{{ $ability->name }}</p>
                                    @endif
                                </div>
                                <p>{{ $ability->text }}</p>
                            @endforeach
                        </div>
                    @endif
                </section>
                <!-- Section pour afficher les attaques du pokémon. Si le pokémon n'a pas d'attaque, ne rien afficher. Sinon afficher les attaques -->
                <section>
                    @if($attacks->count() > 0)
                    <div>
                        <h2 class="uppercase mb-2 text-sm">Attacks:</h2>
                        <div class="mb-5">
                            @foreach($attacks as $attack)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        @foreach($attack->cost as $cost)
                                            <img src="{{ asset('/images/type/'.$cost.'.png') }}"
                                                 alt="{{ $cost }}" class="h-6 w-6 mr-1">
                                        @endforeach
                                        <h2 class="text-2xl ml-2">{{ $attack->name }}</h2>
                                    </div>
                                    <p class="text-xl">{{ $attack->damage }}</p>
                                </div>
                                <p>{{ $attack->text }}</p>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </section>

                <!-- Une carte peut avoir plusieurs règles. Afficher toutes les règles -->
                <section>
                    <!-- Si la carte n'a pas de règles, ne rien afficher (regarder dans la table rules) -->
                    @if($rules->count() > 0)
                        <h2 class="uppercase mb-2">Rules:</h2>
                        @foreach($rules as $rule)
                            <p class="mb-2">{{ $rule->rule }}</p>
                        @endforeach
                    @endif
                </section>
                <!-- Si la carte a une faiblesse, afficher l'image du type -->
                <section>
                    <div class="grid grid-cols-3 gap-4 mt-5">
                        <div>
                            <!-- Si la carte n'a pas de faiblesse, afficher N/A sinon afficher le type et la valeur de la faiblesse -->
                            @if($card->valueWeakness != null)
                                <h2 class="uppercase mb-2 text-sm">Weakness:</h2>
                                    <div class="flex flex-row items-center font-bold">
                                        <img src="{{ asset('/images/type/'.$card->typeWeakness.'.png') }}"
                                             alt="{{ $card->typeWeakness }}" class="w-6 h-auto">
                                        <p class="ml-2 text-xl">{{ $card->valueWeakness }}</p>
                                    </div>
                            @else
                                <h2 class="uppercase mb-2 text-sm">Weakness:</h2>
                                <p class="font-bold text-xl">N/A</p>
                            @endif
                        </div>

                        <div>
                            <!-- Si la carte n'a pas de résistance, afficher N/A sinon afficher la valeur -->
                            @if($card->valueResistance != null)
                                <h2 class="uppercase mb-2 text-sm">Resistance:</h2>
                                    <div class="flex flex-row items-center font-bold">
                                        <img src="{{ asset('/images/type/'.$card->typeResistance.'.png') }}"
                                             alt="{{ $card->typeResistance }}" class="w-6 h-auto">
                                        <p class="ml-2 text-xl">{{ $card->valueResistance }}</p>
                                    </div>
                            @else
                                <h2 class="uppercase mb-2 text-sm">Resistance:</h2>
                                <p class="font-bold text-xl">N/A</p>
                            @endif
                        </div>

                        <div>
                            <!-- Afficher tous les coûts de retraite du pokémon. Si le pokémon n'a pas de coût de retraite, afficher N/A -->
                            @if($card->retreatCost != null && count($card->retreatCost) == $card->convertedRetreatCost)
                                <h2 class="uppercase mb-2 text-sm">Retreat cost:</h2>
                                <div class="flex flex-row">
                                    @foreach($card->retreatCost as $retreatCost)
                                        <img src="{{ asset('/images/type/'.$retreatCost.'.png') }}"
                                             alt="{{ $retreatCost }}"
                                             class="h-6 w-6 mr-1">
                                    @endforeach
                                </div>
                            @else
                                <h2 class="uppercase mb-2 text-sm">Retreat cost:</h2>
                                <p class="font-bold text-xl">N/A</p>
                            @endif
                        </div>

                        <div>
                            <!-- Afficher la rareté de la carte -->
                            <h2 class="uppercase mb-2 text-sm">Rarity:</h2>
                            <p class="font-bold text-xl">{{ $card->rarity }}</p>
                        </div>

                        <div>
                            <!-- Afficher le numéro de la carte dans la série ex: 1 / 146 -->
                            <h2 class="uppercase mb-2 text-sm">Serial number:</h2>
                            <p class="font-bold text-xl">{{ $card->number }} / {{ $set->printedTotal }}</p>
                        </div>

                        <div>
                            <!-- Afficher le nom de l'extension de la carte ainsi que le symbole de l'extension -->
                            <h2 class="uppercase mb-2 text-sm">Set:</h2>
                            <a href="{{ route('set', ['set' => $set->id_set]) }}"
                               class="flex flex-row items-center font-bold">
                                <p class="mr-2 text-xl">{{ $set->name }}</p>
                                <img src="{{ $set->symbol }}" alt="{{ $set->name }}"
                                     class="w-6 h-auto">
                            </a>
                        </div>
                    </div>
                </section>
                <div class="mt-5">
                    @if($card->flavorText != null) <p class="text-sm">{{ $card->flavorText }}</p> @endif
                </div>
            </div>
    </div>
@endsection
