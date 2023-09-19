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
    <div class="card-details">
        <h1>Détails de la carte</h1>
        <div class="card-container" style="display: flex">
            <div class="card-image">
                <!-- Faire en sorte que l'image soit à 20% de sa taille originale -->
                <img src="{{ $card['images']['large'] }}" alt="{{ $card['name'] }}" style="width: 80%;">
            </div>
            <div class="card-info">
                <h2>Name: {{ $card['name'] }}</h2>
                <p>Supertype: {{ $card['supertype'] }}</p>
                <!-- Si le pokemon a plusieurs sous-types, les afficher. Sinon n'afficher que le premier -->
                @if(
                    isset($card['subtypes']) &&
                    is_array($card['subtypes']) &&
                    count($card['subtypes']) > 0
                )
                    <p>Subtype: {{ implode(', ', $card['subtypes']) }}</p>
                @endif
                <!-- Si le pokemon a une capacité, l'afficher avec son type, son nom et son texte -->
                @if(isset($card['abilities']))
                    <p>Ability:</p>
                    <p>Type: {{ $card['abilities'][0]['type'] }}</p>
                    <p>Name: {{ $card['abilities'][0]['name'] }}</p>
                    <p>Text: {{ $card['abilities'][0]['text'] }}</p>
                @endif
                <p>
                    Attacks:
                @if(isset($card['attacks']) && is_array($card['attacks']) && count($card['attacks']) > 0)
                    <ul>
                        @foreach($card['attacks'] as $attack)
                            <li>{{ $attack['name'] }}</li>
                            <!-- Si le pokemon a plusieurs coûts d'attaque, les afficher. Sinon n'afficher que le premier -->
                            @if(isset($attack['cost']) && is_array($attack['cost']) && count($attack['cost']) > 0)
                                <ul>
                                    @foreach($attack['cost'] as $cost)
                                        <li>{{ $cost }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <p>Damage: {{ $attack['damage'] }}</p>
                            <p>Text: {{ $attack['text'] }}</p>
                        @endforeach
                    </ul>
                    @endif
                    </p>
                    <!-- Une carte peut avoir plusieurs règles. Afficher toutes les règles -->
                    @if(isset($card['rules']) && is_array($card['rules']) && count($card['rules']) > 0)
                        <p>Rules:</p>
                        <ul>
                            @foreach($card['rules'] as $rule)
                                <li>{{ $rule }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <!-- Si la carte a une faiblesse, l'afficher -->
                    @if(isset($card['weaknesses']) && is_array($card['weaknesses']) && count($card['weaknesses']) > 0)
                        <p>Weaknesses:</p>
                        <ul>
                            @foreach($card['weaknesses'] as $resistance)
                                <li>{{ $resistance['type'] }}</li>
                                <p>Value: {{ $resistance['value'] }}</p>
                            @endforeach
                        </ul>
                    @else
                        <p>Resistances: N/A</p>
                    @endif
                    <!-- Si la carte n'a pas de résistance, afficher N/A sinon afficher la valeur -->
                    @if(isset($card['resistances']) && is_array($card['resistances']) && count($card['resistances']) > 0)
                        <p>Resistances:</p>
                        <ul>
                            @foreach($card['resistances'] as $resistance)
                                <li>{{ $resistance['type'] }}</li>
                                <p>Value: {{ $resistance['value'] }}</p>
                            @endforeach
                        </ul>
                    @else
                        <p>Resistances: N/A</p>
                    @endif
                    <!-- Afficher tous les coûts de retraite du pokémon -->
                    @if(isset($card['retreatCost']) && is_array($card['retreatCost']) && count($card['retreatCost']) > 0)
                        <p>Retreat Cost:</p>
                        <ul>
                            @foreach($card['retreatCost'] as $cost)
                                <li>{{ $cost }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <!-- Afficher la rareté de la carte -->
                    <p>Rarity: {{ $card['rarity'] }}</p>
                    <!-- Afficher le numéro de la carte dans la série ex: 1 / 146 -->
                    <p>Serie number: {{ $card['number'] }} / {{ $card['set']['total'] }}</p>
                    <p>Artist: {{ $card['artist'] }}</p>
                    <!-- Afficher le nom de l'extension de la carte ainsi que le symbole de l'extension -->
                    <p>Set: {{ $card['set']['name'] }}</p>
                    <img src="{{ $card['set']['images']['symbol'] }}" alt="{{ $card['set']['name'] }}" style="width: 20%;">
            </div>
        </div>
    </div>
@endsection
