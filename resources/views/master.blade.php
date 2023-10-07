<html>
<head>
    @yield('meta')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokemon TCG</title>
    @vite('resources/css/app.css')
</head>
<body class="dark:bg-slate-800 dark:text-white">
<header class="flex shadow-md w-full h-16">
    <a href="{{ route('index') }}" class="flex items-center">
        <img src="{{ asset('images/800px-Feuforêve-RFVF.png') }}" alt="Pokemon logo" class="mr-2 ml-2"
             style="width: 60px; height: auto">
        <h1 class="text-lg">Pokémon TCG Collection</h1>
    </a>
    <nav class="flex items-center ml-auto mr-5">
        <a href="{{ route('sets') }}" class="text-blue-500 hover:text-blue-700 mr-2">Sets</a>
        @if (Route::has('login'))
            <div class="flex items-center mr-5">
                @auth
                    <!-- Dashboard -->
                    <a href="{{ url('/dashboard') }}"
                       class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 dark:text-white dark:hover:text-gray-400">Dashboard</a>
                    <!-- Link to the collection -->
                    <a href="{{ url('/collection') }}"
                       class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 dark:text-white dark:hover:text-gray-400">My
                        collection</a>
                @else
                    <a href="{{ route('login') }}"
                       class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 dark:text-white dark:hover:text-gray-400">Log
                        in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500 dark:text-white dark:hover:text-gray-400">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>
</header>

<div class="container max-w-full p-12">
    @yield('content')
</div>
</body>
</html>
