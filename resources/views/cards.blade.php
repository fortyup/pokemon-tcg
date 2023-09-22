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

    <!-- Afficher les données à partir de la méthode getAllCards() -->
    <div class="card">
        <h1>Ensemble des cartes</h1>
    </div>

    <div class="card-list" style="display: flex; flex-wrap: wrap; justify-content: space-between">
        @foreach($cards as $card)
            <div class="card" style="width: calc(20% - 10px); margin: 5px">
                <a href="{{ route('card', ['id' => $card['id']]) }}">
                    <img src="{{ $card['images']['small'] }}" alt="{{ $card['name'] }}" style="width: 245px;">
                    <h2>{{ $card['name'] }}</h2>
                </a>
            </div>
        @endforeach
    </div>
@endsection
