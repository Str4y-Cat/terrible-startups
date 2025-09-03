
<?php

use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('ideas/{idea}/tools/competitor-search', [ToolController::class, 'showCompetitorSearch'])->name('tool.show_competitor_search');
    Route::post('ideas/{idea}/tools/competitor-search', [ToolController::class, 'createCompetitorSearch'])->name('tool.create_competitor_search');
});
