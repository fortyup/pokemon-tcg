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

    <div class="card">
        <!-- Display the title with card count -->
        <h1 class="text-4xl">All cards - ({{count($cards)}} cards)</h1>
    </div>

    <div class="card-list flex flex-wrap justify-between">
        <!-- Loop through cards and display them -->
        @foreach($cards as $card)
            <div class="card w-[calc(20%-10px)] m-1">
                <a href="{{ route('card', ['card' => $card->id_card]) }}">
                    <!-- Display card image with link to card details -->
                    <img src="{{ $card->smallImage }}" alt="{{ $card->name }}"
                         class="rounded-2xl w-60 hover:scale-125 transition"
                         style="box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.45)">
                </a>
            </div>
        @endforeach
    </div>
@endsection
