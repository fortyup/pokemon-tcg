@extends('master')

@section('content')
    <h1 class="text-4xl font-bold mb-5">{{ $set['name'] }} ({{ $set['id'] }})</h1>

        <!-- Filter by type, name, set/number, rarity -->
        <!-- le faire sous forme de menu déroulant -->
        <form action="{{ route('set', ['id' => $set['id']]) }}" method="get">
            <select name="order">
                <option value="name">Name</option>
                <option value="released">Release Date</option>
                <option value="set">Set/Number</option>
                <option value="rarity">Rarity</option>
            </select>
            <select name="sort">
                <option value="Asc">Asc</option>
                <option value="Desc">Desc</option>
            </select>
            <!-- Search button -->
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                <input type="submit" value="Search">
            </button>
        </form>

        <!-- Displays the list of cards in the set -->
            <div class="card-list flex flex-wrap justify-between">
                @foreach($cards as $card)
                    <div class="card" style="width: calc(20% - 10px); margin: 5px">
                            <a href="{{ route('card', ['id' => $card['id']]) }}">
                                <img src="{{ $card['images']['small'] }}" style="box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.45); border-radius: 10px" alt="{{ $card['name'] }}">
                            </a>
                    </div>
                @endforeach
            </div>
@endsection
