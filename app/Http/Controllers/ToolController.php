<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ToolController extends Controller
{
    //
    //
    public function showCompetitorSearch(Idea $idea)
    {

        /* dd("hello world, $idea->id"); */
        return Inertia::render('tools/CompetitorSearch', [
            "idea" => $idea -> only(['id', 'title'])
        ]);

    }

    public function createCompetitorSearch(Idea $idea)
    {

        //1. create empty instance in the database, status = untouched
        //2. toolType = enum(competitor-search)

        //3. createToolResourceJob (idea, tool, toolType)
        // - set the tool status to processing
        // - queries api
        // - saves response to database
        // - SUCCESS: set status to finished
        // - BROKEN: set status to failed

        //4. return the id of the tool to ping
        //OR
        // 4. ui has a selection of which tables are available. It can see that there is a new value created, but it is processing. so set a spinner, and poll. While it's not processing, dont poll
    }
}
