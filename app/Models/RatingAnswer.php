<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RatingAnswer extends Model
{
    //
    protected $fillable = [
        'score',
        'rating_id',
        'question_id'
    ];

    public function question(): HasOne
    {
        return $this->hasOne(Question::class);
    }

    public function rating(): BelongsTo
    {
        return $this->belongsTo(Rating::class);
    }
}
