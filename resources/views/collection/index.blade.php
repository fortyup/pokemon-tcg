@extends('master')

@section('content')
    <!-- Page Title -->
    <h1 class="text-4xl mb-5">My collection</h1>

    <!-- Card List -->
    @if (count($cards) === 0)
        <p class="text-xl">You don't have any cards in your collection.</p>
    @endif

    <div class="mt-4 grid gap-4 grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
        @foreach($cards as $card)
            <div class="bg-gray-100 dark:bg-slate-700 rounded-lg shadow-md grid grid-cols-1">
                <a href="{{ route('card', ['card' => $card->id_card]) }}">
                    <img src="{{ $card->smallImage }}" alt="{{ $card->name }}"
                         class="rounded-lg w-full hover:scale-110 transition"
                         style="box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.45)">
                </a>
                <div class="p-4">
                    <h3 class="text-xl font-semibold dark:text-white">{{ $card->name }}</h3>
                    <p class="text-gray-500 dark:text-gray-400">{{ $card->set->name }}</p>
                </div>
            </div>
        @endforeach
    </div>

@endsection
