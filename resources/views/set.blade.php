@extends('master')

@section('content')
    <h1 class="text-4xl font-bold mb-5">{{ $set->name }} ({{ $set->id_set }})</h1>

    <!-- Search form for ordering and sorting -->
    <form action="{{ route('set', ['set' => $set->id_set]) }}" method="get">
        <label>
            <!-- Dropdown for ordering -->
            <select name="order" class="dark:bg-slate-200 dark:text-black rounded">
                <option value="set">Set/Number</option>
                <option value="name">Name</option>
                <option value="released">Release Date</option>
                <option value="rarity">Rarity</option>
            </select>
        </label>
        <label>
            <!-- Dropdown for sorting -->
            <select name="sort" class="dark:bg-slate-200 dark:text-black rounded">
                <option value="Asc">Asc</option>
                <option value="Desc">Desc</option>
            </select>
        </label>
        <!-- Search button -->
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <input type="submit" value="Search">
        </button>
    </form>

    <!-- Card list section -->
    <div class="card-list flex flex-wrap justify-between">
        @foreach($cards as $card)
            <div class="card hover:scale-110 transition m-1 w-[calc(20%-10px)]">
                <a href="{{ route('card', ['card' => $card->id_card]) }}">
                    <!-- Card image -->
                    <img src="{{ $card->smallImage }}" class="rounded-2xl"
                         style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.45);" alt="{{ $card->name }}">
                </a>
            </div>
        @endforeach
    </div>
@endsection
