<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Routes de mon application */
Route::get('/cards', [PokemonController::class, 'getAllCards'])->name('cards');
Route::get('/cards/{card}', [PokemonController::class, 'getCard'])->name('card');
Route::get('/sets', [PokemonController::class, 'getSets'])->name('sets');
Route::get('/sets/{set}', [PokemonController::class, 'getSet'])->name('set');
Route::get('/error', [PokemonController::class, 'getError'])->name('error');

Route::middleware(['auth'])->group(function () {
    Route::get('/collection', [CollectionController::class, 'showCollection'])->name('collection.index');
});

/* Fin des routes de mon application */
Route::get('/', IndexController::class)->name('index');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
