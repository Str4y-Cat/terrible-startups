
<?php

use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('ideas/{idea}/tools/competitor-search', [ToolController::class, 'showCompetitorSearch'])->name('tool.competitor_search');
    Route::post('ideas/{idea}/tools/competitor-search', [ToolController::class, 'createCompetitorSearch'])->name('tool.competitor_search');

    Route::get('ideas/{idea}/tools/swot', [ToolController::class, 'showSwot'])->name('tool.swot');
    Route::post('ideas/{idea}/tools/swot', [ToolController::class, 'createSwot'])->name('tool.swot');

    Route::post('ideas/{idea}/tools/context', [ToolController::class, 'context'])->name('tool.context');
});
