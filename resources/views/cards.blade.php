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

    <!-- Afficher les données à partir de la méthode getCards() -->
    <div class="card">
        <h1>Ensemble des cartes</h1>
    </div>

    <div class="card-list">
        @foreach($cards as $card)
            <div class="card">
                <img src="{{ $card['images']['small'] }}" alt="{{ $card['name'] }}">
                <h2>{{ $card['name'] }}</h2>
            </div>
        @endforeach
    </div>
@endsection
