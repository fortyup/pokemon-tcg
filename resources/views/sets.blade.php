@extends('master')

@section('content')
    <h1 class="text-4xl">All sets</h1>
    <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-4 h-full">
        @foreach($sets as $set)
            <div class="bg-white rounded-lg shadow-md p-4">
                <a href="{{ route('set', ['id' => $set['id']]) }}">
                    <div class="h-36 flex w-full justify-center items-center">
                        <img src="{{ $set['images']['logo'] }}" alt="{{ $set['name'] }}"
                             class="max-w-full max-h-full justify-center flex">
                    </div>
                    <div class="flex flex-row items-center p-4">
                        <img src="{{ $set['images']['symbol'] }}" alt="{{ $set['name'] }}" class="w-12 h-12 mr-2">
                        <div class="flex-column">
                            <p class="text-3xl">{{ $set['name'] }}</p>
                            <p>Released {{ $set['releaseDate'] }}</p>
                        </div>
                    </div>
                    <div class="pl-5">
                        @if(isset($set['legalities']) && is_array($set['legalities']))
                            @foreach($set['legalities'] as $legality => $value)
                                @if($legality != 'unlimited')
                                    <li>{{ $legality }} {{ $value }}</li>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </a>
            </div>
        @endforeach
    </div>
@endsection
