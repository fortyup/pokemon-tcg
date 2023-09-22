<html>
<head>
    @yield('meta')

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @vite('resources/css/app.css')

        <title>Pokemon TCG</title>
</head>
<body>

@section('sidebar')

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
