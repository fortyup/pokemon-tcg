@extends('master')

@section('content')
    <div class="container">
        <h1>All sets</h1>
        <div class="collumn" style="display: flex; flex-wrap: wrap">
            @foreach($sets as $set)
                <div class="set" style="margin-bottom: 5%; box-shadow: 0 0.5em 1em -0.125em rgba(10,10,10,.1), 0 0 0 1px rgba(10,10,10,.02); display: block; padding: 1em;">
                    <img src="{{ $set['images']['logo'] }}" alt="{{ $set['name'] }}" style="height: 140px; padding-top: 15px"> <br>
                    <img src="{{ $set['images']['symbol'] }}" alt="{{ $set['name'] }}" style="width: 48px;"><p>Nom du Set: {{ $set['name'] }}</p>
                    <p>Released {{ $set['releaseDate'] }}</p>
                    @if(isset($set['legalities']) && is_array($set['legalities']))
                        @foreach($set['legalities'] as $legality => $value)
                            @if($legality != 'unlimited')
                                <p>{{ $legality }} {{ $value }}</p>
                            @endif
                        @endforeach
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection
