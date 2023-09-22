@extends('master')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="text-center justify-center items-center">
            <h1 class="text-4xl font-bold">Erreur 404</h1>
            <img src="{{ asset('/images/Sprite_0658_chromatique_EV.png') }}" alt="Error 404" class="mx-auto my-4">
            <p class="text-lg">La page que vous recherchez n'existe pas.</p>
        </div>
    </div>
@endsection

