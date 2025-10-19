<?php

namespace App\Services;

use App\Enums\ToolType;
use App\Models\Idea;
use GuzzleHttp\Utils;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class AiService
{
    public $jsonContext;
    public $textContext;
    protected $idea;

    public function __construct(Idea $idea)
    {
        $this->jsonContext = $this->buildJsonContext($idea);
        $this->textContext = $this->buildTextContext($idea);
        $this->idea = $idea;
    }

    public function buildTextContext(Idea $idea): string
    {
        $context =
        "Title: ".$idea->title . "\n".
        "Overview: ". $idea->overview ."\n".
        "Inspiring event or inspiration: ". $idea->inspiration ."\n".
        "Problem to solve: ". $idea->problem_to_solve ."\n".
        "Proposed solution: ". $idea->solution ."\n".
        "Features: \n-". implode("\n- ", $idea->features ?: []) ."\n".
        "Target audience: \n-". implode("\n- ", $idea->target_audience ?: []) ."\n".
        "Potential risks: \n-". implode("\n- ", $idea->risks ?: []) ."\n".
        "Potential challenges: \n-". implode("\n- ", $idea->challenges ?: [])
        ;
        return $context;
    }

    public function buildJsonContext(Idea $idea): Collection
    {
        $idea_context =  collect($idea)->only(['title','overview','inspiration','solution','features','target_audience','risks','challenges']);

        $tags = $idea->tags()
            ->get(['key', 'value']) // only fetch what you need
            ->groupBy('key')
            ->map
            ->pluck('value');

        $idea_context->put('tags', $tags);
        return $idea_context;
    }

    private function queryOpenAi(string $id, string $version): Response
    {
        return  Http::acceptJson()
            ->withToken(config('ai.openai_key'))
            ->withBody(
                Utils::jsonEncode(
                    [
                    "prompt" => [
                        "id" => config($id),
                        "version" => config($version),
                        "variables" => [
                            "business_idea" =>  "$this->jsonContext"
                            ]
                        ]
                    ]
                ),
                'application/json'
            )
            ->post(config('ai.openai_url'));
    }


    public function getCompetitorAnalysis(): Response
    {

        $id = 'ai.openai_competitor_search_prompt_id';
        $version = 'ai.openai_competitor_search_prompt_version';

        return $this->queryOpenAi($id, $version);


    }

    public function getSwot(): Response
    {
        $id = "ai.openai_SWOT_prompt_id";
        $version = "ai.openai_SWOT_prompt_version";

        return $this->queryOpenAi($id, $version);
    }

    public function getRedditCommunities(): Response
    {

        $id = "ai.openai_reddit_communities_prompt_id";
        $version = "ai.openai_reddit_communities_prompt_version";

        return $this->queryOpenAi($id, $version);
    }

    public static function getResponseFor(ToolType $toolType, Idea $idea): Response
    {

        $service = new self($idea);

        $match = match($toolType) {
            ToolType::competitorSearch => $service->getCompetitorAnalysis(),
            ToolType::swot => $service->getSwot(),
            ToolType::redditCommunities => $service->getRedditCommunities(),
        };

        return $match;
    }

}
