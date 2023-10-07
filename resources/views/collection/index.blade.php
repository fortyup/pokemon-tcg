@extends('master')

@section('content')
    <h1 class="text-4xl">My collection</h1>

    <div class="card-list flex flex-wrap justify-between">
        @foreach ($cards as $card)
            <div class="card hover:scale-110 transition m-1 w-[calc(20%-10px)]">
                <a href="{{ route('card', ['card' => $card->id_card]) }}">
                    <img src="{{ $card->smallImage }}" class="rounded-2xl"
                         style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.45);" alt="{{ $card->name }}">
                </a>
            </div>
        @endforeach
    </div>
@endsection
