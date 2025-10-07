<?php

namespace App\Transformers;

use App\Data\ToolData;
use Illuminate\Support\Collection;
use Symfony\Component\String\Exception\InvalidArgumentException;

class ToolDataTransformer
{
    public function __construct()
    {
    }

    public static function fromOpenAi(array $response): ToolData
    {

        $response = collect($response);

        $full_response = $response;
        /* $content = json_decode($response->get('0.output.0.content.0.text'), true); */
        $content = json_decode(data_get($response, '0.full_response.output.0.content.0.text'), true);
        $tokens_used = data_get($response, '0.full_response.usage.total_tokens');
        $model_type = data_get($response, '0.full_response.model');

        if (empty($content) || empty($tokens_used) || empty($model_type)) {
            throw new InvalidArgumentException();
        }

        return ToolData::fromArray([
            "response" => $full_response,
            "content" => $content,
            "tokens_used" => $tokens_used,
            "model_type" => $model_type,
        ]);
    }

}
