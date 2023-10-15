@extends('master')

@section('content')
    <!-- Page Title -->
    <h1 class="text-4xl font-bold dark:text-white mb-5">{{ $collectionName }}</h1>

    <!-- Form for Modifying Collection Name -->
    <form class="mb-5" action="{{ route('collection.update') }}" method="post">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Collection Name:</label>
            <input type="text" name="name" id="name" value="{{ $collectionName }}"
                   class="mt-1 p-2 block w-full border rounded-md dark:border-gray-600 dark:bg-slate-200 focus:ring focus:ring-blue-200">
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Update Name
        </button>
    </form>

    <!-- Search form for ordering and sorting -->
    <form class="mb-5" action="{{ route('collection.index') }}" method="get">
        <label>
            <!-- Dropdown for ordering -->
            <select name="order" class="dark:bg-slate-200 dark:text-black rounded">
                <option value="name" {{ $order === 'name' ? 'selected' : '' }}>Name</option>
                <option value="rarity" {{ $order === 'rarity' ? 'selected' : '' }}>Rarity</option>
                <option value="set" {{ $order === 'set' ? 'selected' : '' }}>Set</option>
            </select>
        </label>
        <label>
            <!-- Dropdown for sorting -->
            <select name="sort" class="dark:bg-slate-200 dark:text-black rounded">
                <option value="Asc" {{ $sort === 'Asc' ? 'selected' : '' }}>Asc</option>
                <option value="Desc" {{ $sort === 'Desc' ? 'selected' : '' }}>Desc</option>
            </select>
        </label>
        <!-- Search button -->
        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            <input type="submit" value="Search">
        </button>
    </form>

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
                <!-- Form for Removing Card from Collection -->
                <form class="pl-4 pb-4" action="{{ route('collection.remove', ['card' => $card->id_card]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Remove</button>
                </form>
            </div>
        @endforeach
    </div>

@endsection
