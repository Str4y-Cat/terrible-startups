<?php

namespace App\Http\Controllers;

use App\Enums\ToolStatus;
use App\Enums\ToolType;
use App\Jobs\ProcessCompetitorSearchJob;
use App\Models\Idea;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ToolController extends Controller
{
    //
    //
    public function showCompetitorSearch(Idea $idea)
    {

        /* dd("hello world, $idea->id"); */
        return Inertia::render('tools/CompetitorSearch', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "competitor_searches" => fn () => $idea->tools()->where('type', ToolType::competitorSearch->value)->get(['status', "content", 'updated_at'])
        ]);

    }

    public function createCompetitorSearch(Idea $idea)
    {

        //1. create empty instance in the database, status = untouched
        //2. toolType = enum(competitor-search)
        $tool = $idea->tools()->create([
            "type" => ToolType::competitorSearch->value,
            "status" => ToolStatus::processing->value,
        ]);
        /* $tool = Tool::create([ */
        /*     "user_id" => Auth::user()->id, */
        /*     "idea_id" => $idea->id, */
        /* ]); */


        ProcessCompetitorSearchJob::dispatch($idea, $tool);

        return response()->json([
            'tool' => [
                'id' => $tool->id,
                'status' => $tool->id,
            ]
        ]);

    }
}
