@extends('master')

@section('meta')
    <!-- Meta tags for character encoding, description, keywords, author, and viewport -->
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Maxime Capel">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <!-- Title section -->
    <title>Pokemon</title>

    <div class="">
        <!-- Main content area -->
        <div class="flex">
            <div>
                <!-- Display card image -->
                <img src="{{ $card->largeImage }}" alt="{{ $card->name }}" class="max-w-md rounded-3xl">
            </div>
            <div class="p-3 ml-40">
                <!-- Card information section -->
                <section>
                    <div class="flex flex-row justify-between">
                        <div class="flex-column">
                            <!-- Display card name and supertype -->
                            <h2 class="text-4xl font-bold">{{ $card->name }}</h2>
                            <p class="text-2xl">{{ $card->supertype }} - {{ $subtypes->pluck('subtype')->implode(', ') }}</p>
                        </div>
                        <div class="flex flex-row items-center">
                            <!-- Display HP and card types -->
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
                <!-- Horizontal rule -->
                <hr style="background-color: #d3d3d3;" class="block h-0.5 m-6 mx-0">
                <section>
                    <!-- Display card abilities -->
                    @if($abilities->count() > 0)
                        <h2 class="uppercase mb-2 text-sm font-light">Abilities:</h2>
                        <div class="mb-5">
                            @foreach($abilities as $ability)
                                <div class="mb-2">
                                    <div class="flex">
                                        @if($ability->type != 'Pokémon Power')
                                            <img src="{{ asset('/images/ability/'.$ability->type.'.png') }}"
                                                 class="w-24 h-auto" alt="{{ $ability->type }}">
                                            <p class="text-2xl ml-2">{{ $ability->name }}</p>
                                        @else
                                            <p class="text-2xl">{{ $ability->name }}</p>
                                        @endif
                                    </div>
                                    <p>{{ $ability->text }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </section>
                <section>
                    <!-- Display card attacks -->
                    @if($attacks->count() > 0)
                        <div>
                            <h2 class="uppercase mb-2 text-sm font-light">Attacks:</h2>
                            <div class="mb-5">
                                @foreach($attacks as $attack)
                                    <div class="flex justify-between items-center mb-2">
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

                <section>
                    <!-- Display card rules -->
                    @if($rules->count() > 0)
                        <h2 class="uppercase mb-2 text-sm font-light">Rules:</h2>
                        @foreach($rules as $rule)
                            <p class="mb-2">{{ $rule->rule }}</p>
                        @endforeach
                    @endif
                </section>
                <section>
                    <!-- Display card attributes such as Weakness, Resistance, Retreat Cost, Rarity, and Serial Number -->
                    <div class="grid grid-cols-3 gap-4 mt-5">
                        <div>
                            <!-- Display Weakness -->
                            @if($card->valueWeakness != null)
                                <h2 class="uppercase mb-2 text-sm font-light">Weakness:</h2>
                                <div class="flex flex-row items-center font-bold">
                                    <img src="{{ asset('/images/type/'.$card->typeWeakness.'.png') }}"
                                         alt="{{ $card->typeWeakness }}" class="w-6 h-auto">
                                    <p class="ml-2 text-xl">{{ $card->valueWeakness }}</p>
                                </div>
                            @else
                                <h2 class="uppercase mb-2 text-sm font-light">Weakness:</h2>
                                <p class="font-bold text-xl">N/A</p>
                            @endif
                        </div>

                        <div>
                            <!-- Display Resistance -->
                            @if($card->valueResistance != null)
                                <h2 class="uppercase mb-2 text-sm font-light">Resistance:</h2>
                                <div class="flex flex-row items-center font-bold">
                                    <img src="{{ asset('/images/type/'.$card->typeResistance.'.png') }}"
                                         alt="{{ $card->typeResistance }}" class="w-6 h-auto">
                                    <p class="ml-2 text-xl">{{ $card->valueResistance }}</p>
                                </div>
                            @else
                                <h2 class="uppercase mb-2 text-sm font-light">Resistance:</h2>
                                <p class="font-bold text-xl">N/A</p>
                            @endif
                        </div>

                        <div>
                            <!-- Display Retreat Cost -->
                            @if($card->retreatCost != null && count($card->retreatCost) == $card->convertedRetreatCost)
                                <h2 class="uppercase mb-2 text-sm font-light">Retreat cost:</h2>
                                <div class="flex flex-row">
                                    @foreach($card->retreatCost as $retreatCost)
                                        <img src="{{ asset('/images/type/'.$retreatCost.'.png') }}"
                                             alt="{{ $retreatCost }}" class="h-6 w-6 mr-1">
                                    @endforeach
                                </div>
                            @else
                                <h2 class="uppercase mb-2 text-sm font-light">Retreat cost:</h2>
                                <p class="font-bold text-xl">N/A</p>
                            @endif
                        </div>

                        <div>
                            <!-- Display Artist -->
                            <h2 class="uppercase mb-2 text-sm font-light">Artist:</h2>
                            <p class="font-bold text-xl">{{ $card->artist }}</p>
                        </div>

                        <div>
                            <!-- Display Rarity -->
                            <h2 class="uppercase mb-2 text-sm font-light">Rarity:</h2>
                            <p class="font-bold text-xl">{{ $card->rarity }}</p>
                        </div>

                        <div>
                            <h2 class="uppercase mb-2 text-sm font-light">Set:</h2>
                            <!-- Link to the set -->
                            <a href="{{ route('set', ['set' => $set->id_set]) }}"
                               class="flex flex-row items-center font-bold">
                                <p class="mr-2 text-xl">{{ $set->name }}</p>
                                <img src="{{ $set->symbol }}" alt="{{ $set->name }}"
                                     class="w-6 h-auto">
                            </a>
                        </div>

                        <div>
                            <!-- Display Serial Number and Set -->
                            <h2 class="uppercase mb-2 text-sm font-light">Serial number:</h2>
                            <p class="font-bold text-xl">{{ $card->number }} / {{ $set->printedTotal }}</p>
                        </div>

                    </div>
                </section>
                <div class="mt-5">
                    <!-- Display card flavor text -->
                    @if($card->flavorText != null) <p class="text-sm">{{ $card->flavorText }}</p> @endif
                </div>
                <!-- Button to add or remove card from collection -->
                @if(Auth::check())
                    <div class="flex mt-5">
                        @if($isInCollection)
                            <form action="{{ route('collection.remove', ['card' => $card->id_card]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                    Delete from collection
                                </button>
                            </form>
                        @else
                            <form action="{{ route('collection.add', ['card' => $card->id_card]) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Add to collection
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
