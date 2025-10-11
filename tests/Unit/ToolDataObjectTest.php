<?php


use App\Enums\ToolType;
use App\Transformers\ToolDataTransformer;
use Symfony\Component\String\Exception\RuntimeException;

it('it returns the ', function () {

    $data = fixture('openAi/CompetitorSearchResponse');
    $toolData = ToolDataTransformer::fromOpenAi($data, ToolType::competitorSearch);

    expect($toolData->response)->not()->toBeNull();
    expect($toolData->content)->not()->toBeEmpty();

    expect($toolData->tokens_used)->toBeInt();
    expect($toolData->model_type)->toEqual("gpt-4.1-2025-04-14");

})->group("transformer");
