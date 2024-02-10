<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta tags for character encoding, viewport, and title -->
    @yield('meta')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pokemon TCG Collection</title>
    <!-- Include CSS using Vite -->
    @vite('resources/css/app.css')
</head>
<body class="dark:bg-slate-800 dark:text-white flex flex-col min-h-screen w-fit">
<header class="flex shadow-md w-full h-16">
    <!-- Logo and site title -->
    <a href="{{ route('index') }}" class="flex items-center">
        <img src="{{ asset('images/800px-Feuforêve-RFVF.png') }}" alt="Pokemon logo" class="mr-2 ml-2"
             style="width: 60px; height: auto">
        <h1 class="text-lg dark:text-white">Pokémon TCG Collection</h1>
    </a>
    <!-- Search form -->
    @if (Route::currentRouteName() != 'index')
        <form action="{{ route('cards') }}" method="GET" class="flex flex-row items-center">
            <input type="text" name="search" id="search"
                   class="border-2 border-gray-300 rounded-md p-2 m-2 dark:bg-slate-300 dark:text-black"
                   placeholder="Search a card by name">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Search
            </button>
        </form>
    @endif
    <!-- Navigation links -->
    <nav class="flex items-center ml-auto mr-5">
        <a href="{{ route('users.index') }}" class="font-semibold text-blue-500 hover:text-blue-700 mr-3">Community</a>
        <a href="{{ route('sets') }}" class="font-semibold text-blue-500 hover:text-blue-700">Sets</a>
        @if (Route::has('login'))
            <div class="flex items-center mr-5">
                @auth
                    <!-- Links for authenticated users -->
                    <!-- Faire un menu déroulant qui affiche le nom de l'utilisateur et qui permet d'accéder à son profil et de se déconnecter -->
                    <div class="relative group ml-4">
                        <button id="user-menu-button"
                                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-white dark:hover:text-gray-400 flex-row flex items-center">
                            <span>{{ Auth::user()->name }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <ul id="user-menu-list"
                            class="absolute hidden mt-2 w-36 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 dark:bg-slate-700"
                            role="menu" aria-orientation="vertical" aria-labelledby="user-menu">
                            <li role="menuitem">
                                <a href="{{ route('profile.edit') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-500">Your profile</a>
                            </li>
                            <li role="menuitem">
                                <a href="{{ url('/collection') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-500">My
                                    collection</a>
                            </li>
                            <li role="menuitem">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-white dark:hover:bg-gray-500"
                                       onclick="event.preventDefault(); this.closest('form').submit();">Log out</a>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <script>
                        const userMenuButton = document.getElementById('user-menu-button');
                        const userMenuList = document.getElementById('user-menu-list');

                        userMenuButton.addEventListener('click', () => {
                            if (userMenuList.classList.contains('hidden')) {
                                userMenuList.classList.remove('hidden');
                            } else {
                                userMenuList.classList.add('hidden');
                            }
                        });

                        // Pour fermer le menu lorsque vous cliquez en dehors
                        document.addEventListener('click', (event) => {
                            if (!userMenuButton.contains(event.target) && !userMenuList.contains(event.target)) {
                                userMenuList.classList.add('hidden');
                            }
                        });
                    </script>

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

<div class="container max-w-full p-12 flex-grow">
    <!-- Content section -->
    @yield('content')
</div>

<footer>
    <div class="flex justify-center items-center h-16 bg-gray-100 dark:bg-slate-700 flex-col p-16">
        <p class="text-gray-600 dark:text-white">© {{date('Y')}} - Made by <a href="https://twitter.com/fortyup_"
                                                                              class="text-blue-500 hover:text-blue-700">fortyup</a>
        </p>
        <p>All datas come from <a href="https://pokemontcg.io/"
                                  class="text-blue-500 hover:text-blue-700">Pokémon TCG API</a></p>
        <p>This website is not produced, endorsed, supported, or affiliated with Nintendo or The Pokémon Company.</p>
    </div>
</footer>
</body>
</html>
