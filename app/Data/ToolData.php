<?php

namespace App\Data;

use App\Enums\ToolStatus;
use App\Enums\ToolType;
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
        public readonly ?ToolType $type,
        public readonly ?Collection $full_response,
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
            collect(data_get($arr, 'full_response')),
            collect(data_get($arr, 'content')),
            data_get($arr, 'tokens_used'),
            data_get($arr, 'model_type'),
        );
    }

    /**
     * Convert the current ToolData instance into a filtered associative array.
     *
     * @return array{
     *     id?: int,
     *     type?: string,
     *     response?: \Illuminate\Support\Collection|null,
     *     content?: \Illuminate\Support\Collection|null,
     *     tokens_used?: int|null,
     *     model_type?: string|null
     * }
     */
    public function asArray(): array
    {
        return collect([
            'id' => $this->id,
            'type' => $this->type->value,
            'full_response' => $this->full_response,
            'content' => $this->content,
            'tokens_used' => $this->tokens_used,
            'model_type' => $this->model_type,
        ])
            ->filter(fn ($item) => !empty($item))
            ->toArray();
    }
}
