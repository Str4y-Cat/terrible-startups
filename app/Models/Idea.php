<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Resource;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */

    use HasFactory;

    protected $fillable = [
            'user_id',
            'title' ,
            "rating" ,
            "overview" ,
            "type" ,
            "problem_to_solve" ,
            "inspiration" ,
            "solution" ,
            "features" ,
            "target_audience" ,
            "risks" ,
            "challenges" ,

    ];



    public function data(Resource $view): array
    {

        return match($view) {

            Resource::Index => [
                'title' => $this->title ,
                "rating" => $this->rating ,
                "id" => $this->id,
                "date_created" => $this->created_at->toDateString() ,
            ],

            Resource::Show => [
                'title' => $this->title ,
                "rating" => $this->rating ,
                "id" => $this->id,
                "overview" => $this->overview ,
                "type" => $this->type ,
                "problem_to_solve" => $this->problem_to_solve ,
                "inspiration" => $this->inspiration ,
                "solution" => $this->solution ,
                "features" => $this->features ,
                "target_audience" => $this->target_audience ,
                "risks" => $this->risks ,
                "challenges" => $this->challenges ,
                "date_created" => $this->created_at->toDateString() ,
            ],

        };
    }

    protected function casts(): array
    {
        return[
            'features' => 'array',
            'target_audience' => 'array',
            'risks' => 'array',
            'challenges' => 'array',
        ];

    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
