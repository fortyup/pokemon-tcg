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

    <div class="card-list flex flex-wrap justify-between">
        @foreach($cards as $card)
            <div class="card w-[calc(20%-10px)] m-1 hover:scale-125 transition">
                <a href="{{ route('card', ['id' => $card['id']]) }}">
                    <img src="{{ $card['images']['small'] }}" alt="{{ $card['name'] }}" class="rounded-2xl w-60" style="box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.45)">
                    <h2>{{ $card['name'] }}</h2>
                </a>
                <!-- Link to the set -->
                <a href="{{ route('set', ['id' => $card['set']['id']]) }}">
                    <p>{{ $card['set']['name'] }}</p>
                </a>
            </div>
        @endforeach
    </div>
@endsection
