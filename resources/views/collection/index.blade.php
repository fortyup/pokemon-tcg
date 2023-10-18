@extends('master')

@section('content')
    @php
        $hasErrors = session('errors') ? session('errors')->any() : false;
    @endphp
        <!-- Page Title with Edit Icon -->
    <h1 class="text-4xl font-bold dark:text-white mb-5 flex flex-row items-center">
        {{$collectionName}}
        <i id="editIcon" class="cursor-pointer ml-2">
            <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none">
                <path
                    d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"
                    stroke="rgb(59 130 246)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path
                    d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"
                    stroke="rgb(59 130 246)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </i>
    </h1>

    <!-- Form for Modifying Collection Name (initially hidden) -->
    <div id="editForm" class="mb-5 {{ $hasErrors ? '' : 'hidden' }} w-72">
        <!-- Form for Modifying Collection Name -->
        <form class="mb-5" action="{{ route('collection.update') }}" method="post">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">New Collection
                    Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name', $collectionName) }}"
                       class="mt-1 p-2 block w-full border rounded-md dark:border-gray-600 dark:bg-slate-200 focus:ring focus:ring-blue-200">
                @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update Name
            </button>
        </form>
    </div>


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
                <form class="pl-4 pb-4" action="{{ route('collection.remove', ['card' => $card->id_card]) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Remove
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <script>
        if ({{ count($cards) }} === 0) {
            document.getElementById('editIcon').style.display = 'none';
        }
        // JavaScript for showing the edit form
        const editIcon = document.getElementById('editIcon');
        const editForm = document.getElementById('editForm');

        editIcon.addEventListener('click', function () {
            editForm.style.display = 'block';
            editIcon.style.display = 'none';
        });
    </script>
@endsection
