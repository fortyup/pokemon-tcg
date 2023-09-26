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
        <h1>Détails de la carte</h1>
        <div class="" style="display: flex">
            <div class="">
                <!-- Faire en sorte que l'image soit à 20% de sa taille originale -->
                <img src="{{ $card['images']['large'] }}" alt="{{ $card['name'] }}" style="width: 310px; border-radius: 20px; box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.45);">
            </div>
            <div class="" style="padding: 0.75rem; margin-left: 8%">
                <h2>Name: {{ $card['name'] }}</h2>
                <p>{{ $card['supertype'] }} - {{ implode(', ', $card['subtypes']) }}</p>
                <!-- Si le pokemon a plusieurs sous-types, les afficher. Sinon n'afficher que le premier -->
                <p>HP {{ $card['hp'] }}</p>
                <!-- Si le pokemon a plusieurs types, afficher les photo des types. Sinon n'afficher que le premier -->
                @if(
                    isset($card['types']) &&
                    is_array($card['types']) &&
                    count($card['types']) > 0
                )
                    @foreach($card['types'] as $type)
                        <img src="{{ asset('/images/type/'.$type.'.png') }}" alt="{{ $type }}" style="width: 25px;">
                    @endforeach
                @endif
                <!-- Si le pokemon a une capacité en [0], l'afficher avec son type, son nom et son texte pareil pour une capacité en [1] sinon ne rienn afficher -->
                @if(isset($card['abilities']) && is_array($card['abilities']) && count($card['abilities']) > 0)
                    <h2>Abilities:</h2>
                    <ul>
                        @foreach($card['abilities'] as $ability)
                            <img src="{{ asset('/images/ability/'.$ability['type'].'.png') }}"
                                 style="width: 100px; height: auto" alt="{{ $ability['type'] }}">
                            <p>{{ $ability['name'] }}</p>
                            <p>{{ $ability['text'] }}</p>
                        @endforeach
                    </ul>
                @endif
                <h2>Attacks:</h2>
                <p>
                @if(isset($card['attacks']) && is_array($card['attacks']) && count($card['attacks']) > 0)
                        @foreach($card['attacks'] as $attack)
                            <li>{{ $attack['name'] }}</li>
                            <!-- Si le pokemon a plusieurs coûts d'attaque, les afficher. Sinon n'afficher que le premier -->
                            @if(isset($attack['cost']) && is_array($attack['cost']) && count($attack['cost']) > 0)
                                    @foreach($attack['cost'] as $cost)
                                    @if(isset($attack['cost']) && is_array($attack['cost']) && count($attack['cost']) > 0)
                                        <img src="{{ asset('/images/type/'.$cost.'.png') }}" alt="{{ $cost }}"
                                             style="width: 25px;">
                @endif
                                    @endforeach
                            @endif
                <p>{{ $attack['damage'] }}</p>
                <p>{{ $attack['text'] }}</p>
                        @endforeach
                    @endif
                    </p>
                    <!-- Une carte peut avoir plusieurs règles. Afficher toutes les règles -->
                    @if(isset($card['rules']) && is_array($card['rules']) && count($card['rules']) > 0)
                        <p>Rules:</p>
                            @foreach($card['rules'] as $rule)
                                <li>{{ $rule }}</li>
                            @endforeach
                    @endif
                <!-- Si la carte a une faiblesse, afficher l'image du type -->
                <div>
                    @if(isset($card['weaknesses']) && is_array($card['weaknesses']) && count($card['weaknesses']) > 0)
                        <h2>Weakness:</h2>
                        @foreach($card['weaknesses'] as $weaknesses)
                            <img src="{{ asset('/images/type/'.$weaknesses['type'].'.png') }}"
                                 alt="{{ $weaknesses['type'] }}" style="width: 25px;">
                            <p>Value: {{ $weaknesses['value'] }}</p>
                            @endforeach
                    @else
                        <h2>Weakness: N/A</h2>
                    @endif
                    <!-- Si la carte n'a pas de résistance, afficher N/A sinon afficher la valeur -->
                    @if(isset($card['resistances']) && is_array($card['resistances']) && count($card['resistances']) > 0)
                        <h2>Resistance:</h2>
                            @foreach($card['resistances'] as $resistance)
                            <img src="{{ asset('/images/type/'.$resistance['type'].'.png') }}"
                                 alt="{{ $resistance['type'] }}" style="width: 25px;">
                                <p>Value: {{ $resistance['value'] }}</p>
                            @endforeach
                    @else
                        <h2>Resistance:</h2>
                        <p>N/A</p>
                    @endif
                    <!-- Afficher tous les coûts de retraite du pokémon -->
                    @if(isset($card['retreatCost']) && is_array($card['retreatCost']) && count($card['retreatCost']) > 0)
                        <h2>Retreat Cost:</h2>
                            @foreach($card['retreatCost'] as $cost)
                            <img src="{{ asset('/images/type/'.$cost.'.png') }}" alt="{{ $cost }}"
                                 style="width: 25px;">
                            @endforeach
                    @endif
                    <!-- Afficher la rareté de la carte -->
                    <h2>Rarity:</h2>
                    <p>{{ $card['rarity'] }}</p>
                    <!-- Afficher le numéro de la carte dans la série ex: 1 / 146 -->
                    <h2>Serie number:</h2>
                    <p>{{ $card['number'] }} / {{ $card['set']['printedTotal'] }}</p>
                    <h2>Artist:</h2>
                    <p>{{ $card['artist'] }}</p>
                    <!-- Afficher le nom de l'extension de la carte ainsi que le symbole de l'extension -->
                    <h2>Set:</h2>
                        <a href="{{ route('set', ['id' => $card['set']['id']]) }}">
                            <p>{{ $card['set']['name'] }}</p>
                            <img src="{{ $card['set']['images']['symbol'] }}" alt="{{ $card['set']['name'] }}" style="width: 25px;">
                        </a>
            </div>
        </div>
    </div>
@endsection
