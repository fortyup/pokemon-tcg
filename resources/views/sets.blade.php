@extends('master')

@section('content')
        <h1>All sets</h1>
        <div class="">
            @foreach($sets as $set)
                <div class="" href="{{ route('set', ['id' => $set['id']]) }}">
                    <a href="{{ route('set', ['id' => $set['id']]) }}">
                        <div class="" style="height: auto; width: auto">
                            <img src="{{ $set['images']['logo'] }}" alt="{{ $set['name'] }}">
                        </div>
                        <div class="">
                            <img src="{{ $set['images']['symbol'] }}" alt="{{ $set['name'] }}">
                            <div>
                                <p class="">{{ $set['name'] }}</p>
                                <p>Released {{ $set['releaseDate'] }}</p>
                            </div>
                        </div>
                        @if(isset($set['legalities']) && is_array($set['legalities']))
                            @foreach($set['legalities'] as $legality => $value)
                                @if($legality != 'unlimited')
                                    <p>{{ $legality }} {{ $value }}</p>
                                @endif
                            @endforeach
                        @endif
                    </a>
                </div>
            @endforeach
        </div>
@endsection
