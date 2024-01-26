@extends('master')

@section('content')
    <!-- Page title -->
    <h1 class="text-4xl mb-5">All sets</h1>

    @foreach($groupedSets as $series => $seriesSets)
        <!-- Display the series name -->
        <h2 class="text-xl mb-3 mt-5 font-bold underline underline-offset-8">{{ $series }}</h2>

        <!-- Grid layout for sets within the series -->
        <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-3 gap-4 h-full">
            @foreach($seriesSets->sortByDesc('releaseDate') as $set)
                <!-- Set card -->
                <div class="bg-gray-100 rounded-lg shadow-md p-4 dark:bg-slate-700">
                    <a href="{{ route('set', ['set' => $set->id_set]) }}">
                        <!-- Set image -->
                        <div class="h-36 flex w-full justify-center items-center">
                            <img src="{{ $set->logo }}" alt="{{ $set->name }}"
                                 class="max-w-full max-h-full justify-center flex">
                        </div>
                        <!-- Set details -->
                        <div class="flex flex-row items-center p-4">
                            <img src="{{ $set->symbol }}" alt="{{ $set->name }}" class="w-12 h-12 mr-2">
                            <div class="flex-column">
                                <!-- Set name -->
                                <p class="text-3xl">{{ $set->name }}</p>
                                <!-- Release date -->
                                <p>Released {{ $set->releaseDate }}</p>
                            </div>
                        </div>
                        <!-- Set legalities -->
                        <div class="pl-5">
                            @foreach($set->legalities as $legality)
                                <ul>
                                    <!-- Check if Standard is Legal -->
                                    @if($legality->standard == 'Legal')
                                        <li>Standard Legal</li>
                                    @endif
                                    <!-- Check if Expanded is Legal -->
                                    @if($legality->expanded == 'Legal')
                                        <li>Expanded Legal</li>
                                    @endif
                                </ul>
                            @endforeach
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <hr style="background-color: #d3d3d3;" class="block h-0.5 m-6 mx-0">
    @endforeach
@endsection
