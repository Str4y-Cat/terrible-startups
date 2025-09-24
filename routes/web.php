<?php

use App\Http\Controllers\IdeaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

/* Route::get('dashboard', function () { */
/*     return redirect()->intended(route('ideas.index', absolute: false)); */
/* })->middleware(['auth', 'verified'])->name('dashboard'); */

Route::get('ideas/show', function () {
    return Inertia::render('ideas/Show');
})->middleware(['auth', 'verified'])->name('ideas/show');

Route::resource('ideas', IdeaController::class)->middleware(['auth', 'verified']);

Route::get('ideas/{idea}/download', [IdeaController::class,'download']);


/* Route::resource('ideas', IdeaController::class); */

require __DIR__.'/note.php';
require __DIR__.'/settings.php';
require __DIR__.'/tools.php';
require __DIR__.'/auth.php';
