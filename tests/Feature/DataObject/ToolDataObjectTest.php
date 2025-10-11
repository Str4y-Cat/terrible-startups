<?php

use App\Enums\ToolType;
use App\Models\Idea;
use App\Models\Tool;
use App\Transformers\ToolDataTransformer;

it('returns a format that can be saved by the tool model', function () {

    $data = fixture('openAi/CompetitorSearchResponse');
    $toolData = ToolDataTransformer::fromOpenAi($data, ToolType::competitorSearch);

    expect($toolData->asArray())->toHaveKeys(['full_response', 'content', 'tokens_used', 'model_type']);

})->group("DTO");
