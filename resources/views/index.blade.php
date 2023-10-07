@extends('master')

@section('meta')
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta name="keywords" content="HTML, CSS, JavaScript">
    <meta name="author" content="Maxime Capel">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
@endsection

@section('content')
    <div>
        <!-- Contenu centré verticalement et horizontalement -->
        <div class="flex flex-col items-center mt-56">
            <h1 class="text-4xl">Pokémon TCG Collection</h1>
            <h2 class="text-xl font-light">
                This website is a collection of all the cards from the Pokémon TCG.
            </h2>
            <!-- Faire en sorte que le formulaire soit centré et prenne toute la largeur -->
                <form action="" method="POST" class="flex flex-row items-center">
                    <input type="text" name="search" id="search" class="border-2 border-gray-300 rounded-md p-2 m-2"
                           placeholder="Search for a card">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Search
                    </button>
                </form>
        </div>
    </div>
@endsection
