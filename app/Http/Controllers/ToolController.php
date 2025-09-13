<?php

namespace App\Http\Controllers;

use App\Enums\ToolStatus;
use App\Enums\ToolType;
use App\Jobs\ProcessCompetitorSearchJob;
use App\Jobs\ProcessRedditSearchJob;
use App\Jobs\ProcessSwotJob;
use App\Models\Idea;
use App\Models\Tool;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ToolController extends Controller
{
    //COMPETITOR SEARCH
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

        return Inertia::render('tools/CompetitorSearch', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "competitor_searches" => fn () => $idea->tools()->where('type', ToolType::competitorSearch->value)->get(['status', "content", 'updated_at'])
        ]);

    }


    //SWOT ANALYSIS
    public function showSwot(Idea $idea)
    {

        return Inertia::render('tools/SwotAnalysis', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "swots" => fn () => $idea->tools()->where('type', ToolType::swot->value)->get(['status', "content", 'updated_at'])
        ]);

    }

    public function createSwot(Idea $idea)
    {

        //1. create empty instance in the database, status = untouched
        //2. toolType = enum(competitor-search)
        $tool = $idea->tools()->create([
            "type" => ToolType::swot->value,
            "status" => ToolStatus::processing->value,
        ]);
        /* $tool = Tool::create([ */
        /*     "user_id" => Auth::user()->id, */
        /*     "idea_id" => $idea->id, */
        /* ]); */

        ProcessSwotJob::dispatch($idea, $tool);

        /* ProcessSwotJob::dispatch($idea, $tool); */

        return Inertia::render('tools/SwotAnalysis', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "swots" => fn () => $idea->tools()->where('type', ToolType::competitorSearch->value)->get(['status', "content", 'updated_at'])
        ]);

    }


    //SWOT ANALYSIS
    public function showRedditCommunities(Idea $idea)
    {

        return Inertia::render('tools/RedditCommunities', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "community_searches" => fn () => $idea->tools()->where('type', ToolType::redditCommunities->value)->get(['status', "content", 'updated_at'])
        ]);

    }

    public function createRedditCommunities(Idea $idea)
    {

        //1. create empty instance in the database, status = untouched
        //2. toolType = enum(competitor-search)
        $tool = $idea->tools()->create([
            "type" => ToolType::redditCommunities->value,
            "status" => ToolStatus::processing->value,
        ]);
        /* $tool = Tool::create([ */
        /*     "user_id" => Auth::user()->id, */
        /*     "idea_id" => $idea->id, */
        /* ]); */

        /* ProcessRedditSearchJob::dispatchSync($idea, $tool); */
        ProcessRedditSearchJob::dispatch($idea, $tool);
        /* ProcessSwotJob::dispatch($idea, $tool); */

        return Inertia::render('tools/RedditCommunities', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "community_searches" => fn () => $idea->tools()->where('type', ToolType::competitorSearch->value)->get(['status', "content", 'updated_at'])
        ]);

    }


    public function context(Idea $idea)
    {

        $aiService = new AiService($idea);
        $context = $aiService->buildJsonContext($idea);

        return $context;
    }
}
