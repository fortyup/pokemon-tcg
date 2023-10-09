<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character encoding, viewport, and title -->
    @yield('meta')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokemon TCG</title>
    <!-- Include CSS using Vite -->
    @vite('resources/css/app.css')
</head>
<body class="dark:bg-slate-800 dark:text-white">
<header class="flex shadow-md w-full h-16">
    <!-- Logo and site title -->
    <a href="{{ route('index') }}" class="flex items-center">
        <img src="{{ asset('images/800px-Feuforêve-RFVF.png') }}" alt="Pokemon logo" class="mr-2 ml-2"
             style="width: 60px; height: auto">
        <h1 class="text-lg">Pokémon TCG Collection</h1>
    </a>
    <!-- Search form -->
    @if (Route::currentRouteName() != 'index')
        <form action="{{ route('cards') }}" method="GET" class="flex flex-row items-center">
            <input type="text" name="search" id="search" class="border-2 border-gray-300 rounded-md p-2 m-2 dark:bg-slate-300 dark:text-black"
                   placeholder="Search a card by name">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Search
            </button>
        </form>
    @endif
    <!-- Navigation links -->
    <nav class="flex items-center ml-auto mr-5">
        <a href="{{ route('sets') }}" class="font-semibold text-blue-500 hover:text-blue-700 mr-2">Sets</a>
        @if (Route::has('login'))
            <div class="flex items-center mr-5">
                @auth
                    <!-- Links for authenticated users -->
                    <a href="{{ url('/dashboard') }}"
                       class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-gray-400">Dashboard</a>
                    <a href="{{ url('/collection') }}"
                       class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-gray-400">My
                        collection</a>
                @else
                    <!-- Links for guests -->
                    <a href="{{ route('login') }}"
                       class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-gray-400">Log
                        in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-gray-400">Register</a>
                    @endif
                @endauth
            </div>
        @endif
    </nav>
</header>

<div class="container max-w-full p-12">
    <!-- Content section -->
    @yield('content')
</div>
</body>
</html>
