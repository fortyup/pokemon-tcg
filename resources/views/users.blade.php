@extends('master')

@section('content')
    <h1 class="text-4xl font-bold dark:text-white">Collections of all users</h1>

    <div class="mt-6 grid gap-8">
        @foreach($collections as $userName => $cardCollection)
            <div class="bg-gray-100 dark:bg-slate-700 p-4 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold dark:text-white">{{ $userName }}'s Collection</h2>
                @if(count($cardCollection) > 0)
                    <ul class="mt-4">
                        @foreach($cardCollection as $card)
                            <div class="flex items-center justify-between border-t border-gray-300 dark:border-gray-700 pt-2">
                                <a href="{{ route('card', ['card' => $card->id_card]) }}">
                                    <p class="dark:text-white hover:text-blue-500">{{ $card->name }} ({{ $card->id_card }})</p>
                                </a>
                                <p class="text-gray-600 dark:text-gray-400">{{ $card->artist }}</p>
                                <a href="{{ route('set', ['set' => $card->set->id_set]) }}"
                                   class="flex flex-row items-center hover:text-blue-500">
                                    <p class="mr-2">{{ $card->set->name }}</p>
                                    <img src="{{ $card->set->symbol }}" alt="{{ $card->set->name }}"
                                         class="w-auto h-4">
                                </a>
                            </div>
                        @endforeach
                    </ul>
                @else
                    <p class="mt-4 text-gray-500 dark:text-gray-400">This user has no cards in his collection.</p>
                @endif
            </div>
        @endforeach

        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>
@endsection
