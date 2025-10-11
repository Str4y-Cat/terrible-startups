<?php

namespace App\Transformers;

use App\Data\ToolData;
use App\Enums\ToolStatus;
use App\Enums\ToolType;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\String\Exception\InvalidArgumentException;

class ToolDataTransformer
{
    public function __construct()
    {
    }

    //REFACTOR: Move the type, globaly, to a enum
    public static function fromOpenAi(array|Collection|Response $response, ToolType $toolType): ToolData
    {

        if ($response instanceof Response) {
            $response = $response->collect();
        }

        if (is_array($response)) {
            $response = collect($response);
        }
        /* Log::debug('ToolDataTransformer: starting to transform', ['response' => $response]); */


        $full_response = $response;
        /* $content = json_decode($response->get('0.output.0.content.0.text'), true); */
        $content = json_decode(self::getContent($response, $toolType), true);
        $tokens_used = data_get($response, 'usage.total_tokens');
        $model_type = data_get($response, 'model');

        if (empty($content)) {
            /* Log::error('ToolDataTransformer: Content is null', ['response' => $response]); */
            throw new InvalidArgumentException("Content is null");

        }

        if (empty($tokens_used)) {
            /* Log::error('ToolDataTransformer: Tokens are null'); */
            throw new InvalidArgumentException("Tokens used is null");
        }

        if (empty($model_type)) {
            /* Log::error('ToolDataTransformer: model type is null'); */
            throw new InvalidArgumentException("Model is null");
        }


        return ToolData::fromArray([
            "type" => $toolType,
            "full_response" => $full_response,
            "content" => $content,
            "tokens_used" => $tokens_used,
            "model_type" => $model_type,
        ]);
    }

    public static function getContent(Collection $response, ToolType $toolType)
    {
        return match($toolType) {
            ToolType::swot => data_get($response, 'output.0.content.0.text'),
            ToolType::competitorSearch => data_get($response, 'output.1.content.0.text'),
            ToolType::redditCommunities => data_get($response, 'output.0.content.0.text'),
        };
    }

}
