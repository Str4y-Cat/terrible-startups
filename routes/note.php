<?php


use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::patch('ideas/{idea}/note', [NoteController::class, 'update'])->name('note.update');
});
