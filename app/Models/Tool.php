<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ToolType;
use App\Enums\ToolStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tool extends Model
{
    /** @use HasFactory<\Database\Factories\ToolFactory> */
    use HasFactory;

    protected $fillable = [
        "full_response",
        "content",
        'type',
        'status',
        'tokens_used',
        'model_type',
    ];

    protected $casts = [
        "type" => ToolType::class,
        'status' => ToolStatus::class,
        'content' => 'array',
        'full_response' => 'array',
    ];

    public function idea(): BelongsTo
    {
        return this->belongsTo(Idea::class);
    }

}
