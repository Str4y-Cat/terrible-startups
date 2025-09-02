
<?php

use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::get('ideas/{idea}/tools/competitor-search', [ToolController::class, 'competitorSearch'])->name('tool.competitor_search');
});
