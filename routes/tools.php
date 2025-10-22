
<?php

use App\Http\Controllers\ToolController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::post('ideas/{idea}/tools/context', [ToolController::class, 'context'])->name('tool.context');

    /* Route::get('ideas/{idea}/tools/competitor-search', [ToolController::class, 'showCompetitorSearch'])->name('tool.competitor_search'); */
    /* Route::post('ideas/{idea}/tools/competitor-search', [ToolController::class, 'createCompetitorSearch'])->name('tool.competitor_search'); */

    /* Route::get('ideas/{idea}/tools/swot', [ToolController::class, 'showSwot'])->name('tool.swot'); */
    /* Route::post('ideas/{idea}/tools/swot', [ToolController::class, 'createSwot'])->name('tool.swot'); */


    /* Route::get('ideas/{idea}/tools/reddit-community-search', [ToolController::class, 'showRedditCommunities'])->name('tool.reddit_community_search'); */
    /* Route::post('ideas/{idea}/tools/reddit-community-search', [ToolController::class, 'createRedditCommunities'])->name('tool.reddit_community_search'); */

    Route::get('ideas/{idea}/tool', [ToolController::class, 'showTool'])->name('tool');
    Route::post('ideas/{idea}/tool', [ToolController::class, 'createTool'])->name('tool');

});
