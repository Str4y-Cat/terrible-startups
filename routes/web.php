<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

/* Route::get('dashboard', function () { */
/*     return redirect()->intended(route('ideas.index', absolute: false)); */
/* })->middleware(['auth', 'verified'])->name('dashboard'); */




/* Route::resource('ideas', IdeaController::class); */

require __DIR__.'/ideas.php';
require __DIR__.'/note.php';
require __DIR__.'/settings.php';
require __DIR__.'/tools.php';
require __DIR__.'/auth.php';
