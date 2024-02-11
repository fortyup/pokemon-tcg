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
        <h1 class="text-4xl mb-5">All cards - ({{ $cards->total() }} cards)</h1>
    </div>

    <div class="card-list grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        <!-- Loop through cards and display them -->
        @foreach($cards as $card)
            <div class="card m-1
                @if($card->isInCollection)
                    grayscale
                @endif">
                <a href="{{ route('card', ['card' => $card->id_card]) }}">
                    <!-- Display card image with link to card details -->
                    <img src="{{ $card->smallImage }}" alt="{{ $card->name }}"
                         class="rounded-2xl w-full hover:scale-125 transition"
                         style="box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.45)">
                </a>
            </div>
        @endforeach
    </div>

    <!-- Display pagination links with the search query parameter -->
    <div class="my-12">
        {{ $cards->appends(['search' => request('search')])->links() }}
    </div>
@endsection
