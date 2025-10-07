<?php

namespace App\Data;

use Illuminate\Support\Collection;

/**
 * Data Transfer Object representing a tool response.
 *
 * @property-read int|null $id          The unique identifier of the tool instance.
 * @property-read string|null $type     The type or category of the tool.
 * @property-read Collection|null $response  The tool's response payload (may contain structured data).
 * @property-read Collection|null $content   The tool's content payload (e.g., metadata or processed output).
 * @property-read int|null $tokens_used Number of tokens used in a request or response.
 * @property-read string|null $model_type The model or engine type used to generate the response.
 */
class ToolData
{
    public function __construct(
        public readonly ?int $id,
        public readonly ?string $type,
        public readonly ?Collection $response,
        public readonly ?Collection $content,
        public readonly ?int $tokens_used,
        public readonly ?string $model_type,
    ) {
    }

    /**
        * Create a new {@see ToolData} instance from a keyed array.
        *
        * @param array{ id?: int|null, type?: string|null, response?: array<int|string, mixed>|Collection|null, content?: array<int|string, mixed>|Collection|null, tokens_used?: int|null, model_type?: string|null } $arr  The source array to transform into a ToolData object.
        *
        * @return self
        */
    public static function fromArray(array $arr): ToolData
    {
        return new self(
            data_get($arr, 'id'),
            data_get($arr, 'type'),
            collect(data_get($arr, 'response')),
            collect(data_get($arr, 'content')),
            data_get($arr, 'tokens_used'),
            data_get($arr, 'model_type'),
        );
    }
}
