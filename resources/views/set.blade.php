@extends('master')

@section('content')
    <h1>{{ $set['name'] }} ({{ $set['id'] }})</h1>

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
            <input type="submit" value="Search">
        </form>

        <!-- Displays the list of cards in the set -->
            <div class="card-list" style="display: flex; flex-wrap: wrap; justify-content: space-between">
                @foreach($cards as $card)
                    <div class="card" style="width: calc(20% - 10px); margin: 5px">
                        <div>
                            <a href="{{ route('card', ['id' => $card['id']]) }}">
                                <img src="{{ $card['images']['small'] }}" style="box-shadow: 5px 5px 6px rgba(0, 0, 0, 0.45); border-radius: 10px" alt="{{ $card['name'] }}">
                            </a>
                        </div>
                        <div>
                            <p>{{ $card['name'] }}</p>
                            <p>{{ $card['number'] }}/{{ $card['set']['printedTotal'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
@endsection
