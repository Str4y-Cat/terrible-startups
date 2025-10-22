<?php

namespace App\Http\Controllers;

use App\Enums\ToolStatus;
use App\Enums\ToolType;
use App\Jobs\ProcessToolJob;
use App\Models\Idea;
use App\Models\Tool;
use App\Services\AiService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Inertia\Response;

class ToolController extends Controller
{
    //REFACTOR: we could probably refactor this into one option.
    //Then we add the tool type in the parameter. i.e tool?tooltype=competitorsearch

    //Tool Show

    public function showTool(Idea $idea, Request $request): Response
    {
        $toolType = ToolType::tryFrom($request->type);

        if (!$toolType) {
            return redirect()->back();
        }

        $page = match($toolType) {
            $toolType::competitorSearch => 'CompetitorSearch',
            $toolType::swot => 'SwotAnalysis',
            $toolType::redditCommunities => 'RedditCommunities',
        };

        return Inertia::render("tools/Tool", [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "tool_results" => fn () => $idea->tools()->where('type', $toolType->value)->get(['status', "content", 'updated_at']),
            "tool_type" => $toolType->value
        ]);
    }
    //Tool Create

    public function createTool(Idea $idea, Request $request): Response
    {

        $toolType = ToolType::tryFrom($request->type);

        if (!$toolType) {
            return redirect()->back();
        }

        //1. create empty instance in the database, status = untouched
        //2. toolType = enum(competitor-search)
        $tool = $idea->tools()->create([
            "type" => $toolType,
            "status" => ToolStatus::processing,
        ]);

        ProcessToolJob::dispatch($idea, $tool);

        $page = match($toolType) {
            $toolType::competitorSearch => 'CompetitorSearch',
            $toolType::swot => 'SwotAnalysis',
            $toolType::redditCommunities => 'RedditCommunities',
        };

        return Inertia::render("tools/{$page}", [
            "idea" => fn () => $idea -> only(['id', 'title']),
            "tool_results" => fn () => $idea->tools()->where('type', $toolType->value)->get(['status', "content", 'updated_at'])
        ]);

    }

    public function context(Idea $idea): Collection
    {

        $aiService = new AiService($idea);
        $context = $aiService->buildJsonContext($idea);

        return $context;
    }
}
