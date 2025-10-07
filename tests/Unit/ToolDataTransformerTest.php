<?php


use App\Transformers\ToolDataTransformer;
use Symfony\Component\String\Exception\RuntimeException;

it('transforms OpenAI response JSON into ToolData object', function () {

    /* $data = fixture('openAi/CompetitorSearchResponse.json'); */


    $data = fixture('openAi/SwotResponse');
    $toolData = ToolDataTransformer::fromOpenAi($data);

    /* dd($toolData); */

    expect($toolData->response)->not()->toBeNull();
    expect($toolData->content)->not()->toBeEmpty();

    expect($toolData->tokens_used)->toEqual(2810);
    expect($toolData->model_type)->toEqual("gpt-4.1-2025-04-14");



})->group("transformer");
