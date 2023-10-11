@extends('master')

@section('content')
    <!-- Page Title -->
    <h1 class="text-4xl mb-5">My collection</h1>

    <!-- Card List -->
    @if (count($cards) === 0)
        <p class="text-xl">You don't have any cards in your collection.</p>
    @endif
    <div class="card-list flex flex-wrap justify-between">
        @foreach ($cards as $card)
            <div class="m-1 w-[calc(20%-10px)]">
                <!-- Individual Card -->
                <div class="card hover:scale-110 transition">
                    <!-- Link to View Card Details -->
                    <a href="{{ route('card', ['card' => $card->id_card]) }}">
                        <img src="{{ $card->smallImage }}" class="rounded-2xl"
                             style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.45);" alt="{{ $card->name }}">
                    </a>
                </div>

                <!-- Form for Removing Card from Collection -->
                <form action="{{ route('collection.remove', ['card' => $card->id_card]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove</button>
                </form>
            </div>
        @endforeach
    </div>
@endsection
