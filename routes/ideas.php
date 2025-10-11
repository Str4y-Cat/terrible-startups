<?php


use App\Http\Controllers\IdeaController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('ideas/show', function () {
        return Inertia::render('ideas/Show');
    });

    Route::resource('ideas', IdeaController::class)->middleware(['auth', 'verified']);

    Route::get('ideas/{idea}/download', [IdeaController::class,'download']);
    Route::patch('ideas/{idea}/rating', [RatingController::class,'update'])->name('rating.update');

    Route::post('ideas/{idea}/tags/sync', [TagController::class,'sync'])->name('tags.sync');
});
