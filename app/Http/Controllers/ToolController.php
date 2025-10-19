<?php

namespace App\Http\Controllers;

use App\Enums\ToolStatus;
use App\Enums\ToolType;
use App\Jobs\ProcessToolJob;
use App\Models\Idea;
use App\Services\AiService;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class ToolController extends Controller
{
    //REFACTOR: we could probably refactor this into one option.
    //Then we add the tool type in the parameter. i.e tool?tooltype=competitorsearch

    //COMPETITOR SEARCH
    public function showCompetitorSearch(Idea $idea): Response
    {

        /* dd("hello world, $idea->id"); */
        return Inertia::render('tools/CompetitorSearch', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "competitor_searches" => fn () => $idea->tools()->where('type', ToolType::competitorSearch->value)->get(['status', "content", 'updated_at'])
        ]);

    }

    public function createCompetitorSearch(Idea $idea): Response
    {

        //1. create empty instance in the database, status = untouched
        //2. toolType = enum(competitor-search)
        $tool = $idea->tools()->create([
            "type" => ToolType::competitorSearch->value,
            "status" => ToolStatus::processing->value,
        ]);

        ProcessToolJob::dispatch($idea, $tool);

        return Inertia::render('tools/CompetitorSearch', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "competitor_searches" => fn () => $idea->tools()->where('type', ToolType::competitorSearch->value)->get(['status', "content", 'updated_at'])
        ]);

    }


    //SWOT ANALYSIS
    public function showSwot(Idea $idea): Response
    {

        return Inertia::render('tools/SwotAnalysis', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "swots" => fn () => $idea->tools()->where('type', ToolType::swot->value)->get(['status', "content", 'updated_at'])
        ]);

    }

    public function createSwot(Idea $idea): Response
    {

        //1. create empty instance in the database, status = untouched
        //2. toolType = enum(competitor-search)
        $tool = $idea->tools()->create([
            "type" => ToolType::swot->value,
            "status" => ToolStatus::processing->value,
        ]);
        ProcessToolJob::dispatch($idea, $tool);

        return Inertia::render('tools/SwotAnalysis', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "swots" => fn () => $idea->tools()->where('type', ToolType::swot->value)->get(['status', "content", 'updated_at'])
        ]);

    }


    //SWOT ANALYSIS
    public function showRedditCommunities(Idea $idea): Response
    {

        return Inertia::render('tools/RedditCommunities', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "community_searches" => fn () => $idea->tools()->where('type', ToolType::redditCommunities->value)->get(['status', "content", 'updated_at'])
        ]);

    }

    public function createRedditCommunities(Idea $idea): Response
    {

        //1. create empty instance in the database, status = untouched
        //2. toolType = enum(competitor-search)
        $tool = $idea->tools()->create([
            "type" => ToolType::redditCommunities->value,
            "status" => ToolStatus::processing->value,
        ]);

        ProcessToolJob::dispatch($idea, $tool);

        return Inertia::render('tools/RedditCommunities', [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "community_searches" => fn () => $idea->tools()->where('type', ToolType::redditCommunities->value)->get(['status', "content", 'updated_at'])
        ]);

    }


    public function context(Idea $idea): Collection
    {

        $aiService = new AiService($idea);
        $context = $aiService->buildJsonContext($idea);

        return $context;
    }
}
