<?php

namespace App\Services;

use App\Models\Idea;
use GuzzleHttp\Utils;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

use function GuzzleHttp\json_decode;
use function GuzzleHttp\json_encode;

class AiService
{
    protected $jsonContext;
    protected $textContext;
    protected $idea;

    public function __construct(Idea $idea)
    {
        $this->jsonContext = $this->buildJsonContext($idea);
        $this->textContext = $this->buildTextContext($idea);
        $this->idea = $idea;
    }



    public function buildTextContext(Idea $idea)
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

    public function buildJsonContext(Idea $idea)
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


    public function getCompetitorAnalysis(): Response
    {
        return  Http::acceptJson()
            ->withToken(config('ai.openai_key'))
            ->withBody(
                Utils::jsonEncode(
                    [
                    "prompt" => [
                        "id" => config('ai.openai_competitor_search_prompt_id'),
                        "version" => config('ai.openai_competitor_search_prompt_version'),
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

    public function getSwot(): Response
    {
        return  Http::acceptJson()
            ->withToken(config('ai.openai_key'))
            ->withBody(
                Utils::jsonEncode(
                    [
                    "prompt" => [
                        "id" => config('ai.openai_SWOT_prompt_id'),
                        "version" => config('ai.openai_SWOT_prompt_version'),
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

    public function getFeedback(): Response
    {
        return  Http::acceptJson()
            ->withToken(config('app.openai_key'))
            ->withBody(
                Utils::jsonEncode(
                    [
                    "prompt" => [
                        "id" => config('app.openai_id'),
                        "version" => config('app.openai_version'),
                        "variables" => [
                            "business_idea" =>  "$this->jsonContext"
                            ]
                        ]
                    ]
                ),
                'application/json'
            )
            ->post(config('app.openai_url'));
    }
}
