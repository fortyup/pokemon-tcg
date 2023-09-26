<html>
<head>
    @yield('meta')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokemon TCG</title>
</head>
<body>
<header style="display: flex; align-items: center;">
    <div style="width: 100%; display: flex; flex-direction: row; align-items: center;">
        <a href="{{ route('index') }}" style="display: flex; align-items: center; width: 100%">
            <img src="{{ asset('images/800px-Feuforêve-RFVF.png') }}" style="height: 50px; width: auto; margin-left: 5%; margin-right: 2%;" alt="Pokemon TGC logo">
            <h1>Pokémon TCG Collection</h1>
        </a>
    </div>
    <nav style="display: flex; flex-direction: row;">
        <a href="{{ route('sets') }}" style="margin: 10px;">Sets</a>
        <a href="{{ route('cards') }}" style="margin: 10px;">Cards</a>
    </nav>
</header>


@section('sidebar')
@endsection

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
