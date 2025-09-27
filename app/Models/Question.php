<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Question extends Model
{
    use HasFactory;

    //
    protected $fillable = [
        'heading',
        'description',
        'choices',

        'order',
        'is_active',
    ];

    protected $casts = [
        'choices' => 'array'
    ];

    public function ratingAnswer(): BelongsTo
    {
        return $this->belongsTo(RatingAnswer::class);
    }
}
