@extends('master')

@section('content')
    <h1 class="text-4xl font-bold mb-5">{{ $set['name'] }} ({{ $set['id'] }})</h1>

        <!-- Filter by type, name, set/number, rarity -->
        <!-- le faire sous forme de menu déroulant -->
        <form action="{{ route('set', ['id' => $set['id']]) }}" method="get">
            <label>
                <select name="order">
                    <option value="set">Set/Number</option>
                    <option value="name">Name</option>
                    <option value="released">Release Date</option>
                    <option value="rarity">Rarity</option>
                </select>
            </label>
            <label>
                <select name="sort">
                    <option value="Asc">Asc</option>
                    <option value="Desc">Desc</option>
                </select>
            </label>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <input type="submit" value="Search">
            </button>
        </form>

        <!-- Displays the list of cards in the set -->
            <div class="card-list flex flex-wrap justify-between">
                @foreach($cards as $card)
                    <div class="card hover:scale-125 transition m-1 w-[calc(20%-10px)]">
                            <a href="{{ route('card', ['id' => $card['id']]) }}">
                                <img src="{{ $card['images']['small'] }}" class="rounded-2xl" style="box-shadow: 5px 5px 5px rgba(0, 0, 0, 0.45);" alt="{{ $card['name'] }}">
                            </a>
                    </div>
                @endforeach
            </div>
@endsection
