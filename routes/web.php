<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SetController;
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

/* Routes of my application */
Route::get('/cards', [CardController::class, 'getAllCards'])->name('cards');
Route::post('/cards', [CardController::class, 'getAllCards'])->name('process.cards');
Route::get('/cards/{card}', [CardController::class, 'getCard'])->name('card');
Route::get('/sets', [SetController::class, 'getSets'])->name('sets');
Route::get('/sets/{set}', [SetController::class, 'getSet'])->name('set');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/collection', [CollectionController::class, 'showCollection'])->name('collection.index');
    Route::patch('/collection', [CollectionController::class, 'modifyNameCollection'])->name('collection.update');
    Route::delete('/collection/{card}', [CollectionController::class, 'removeCard'])->name('collection.remove');
    Route::post('/cards/{card}', [CollectionController::class, 'addCard'])->name('collection.add');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [CollectionController::class, 'showCollectionOtherUsers'])->name('users.index');
    Route::get('/users/{id}', [CollectionController::class, 'showCollectionOtherUsersId'])->name('users.show');
});

/* End of routes of my application */

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
