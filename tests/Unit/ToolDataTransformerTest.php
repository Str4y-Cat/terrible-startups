<?php


use App\Enums\ToolType;
use App\Transformers\ToolDataTransformer;
use Symfony\Component\String\Exception\RuntimeException;

it('transforms OpenAI "Competitor Search" response JSON into ToolData object', function () {

    $data = fixture('openAi/CompetitorSearchResponse');
    $toolData = ToolDataTransformer::fromOpenAi($data, ToolType::competitorSearch);

    expect($toolData->full_response)->not()->toBeNull();
    expect($toolData->content)->not()->toBeEmpty();

    expect($toolData->tokens_used)->toBeInt();
    expect($toolData->model_type)->toEqual("gpt-4.1-2025-04-14");

})->group("transformer");

it('transforms OpenAI "SWOT" response JSON into ToolData object', function () {

    /* $data = fixture('openAi/CompetitorSearchResponse.json'); */


    $data = fixture('openAi/SwotResponse');
    $toolData = ToolDataTransformer::fromOpenAi($data, ToolType::swot);

    /* dd($toolData); */

    expect($toolData->full_response)->not()->toBeNull();
    expect($toolData->content)->not()->toBeEmpty();

    expect($toolData->tokens_used)->toBeInt();
    expect($toolData->model_type)->toEqual("gpt-4.1-2025-04-14");



})->group("transformer");


it('transforms OpenAI "Reddit Community Search" response JSON into ToolData object', function () {

    $data = fixture('openAi/CommunitySearchResponse');
    $toolData = ToolDataTransformer::fromOpenAi($data, ToolType::redditCommunities);

    expect($toolData->full_response)->not()->toBeNull();
    expect($toolData->content)->not()->toBeEmpty();

    expect($toolData->tokens_used)->toBeInt();
    expect($toolData->model_type)->toEqual("gpt-4.1-2025-04-14");

})->group("transformer");
