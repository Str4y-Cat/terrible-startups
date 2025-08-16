<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Resource;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        $tags = [];

        if ($view == Resource::Index) {
            $tags =  $this->tags()->get()->map(
                function (Tag $tag, int $index) {
                    return $tag->getData();
                }
            )->filter(function (array $tag) {
                return  $tag["key"] == "industry" || $tag["key"] == "business model" || $tag["key"] ==
                "customer segment";
            });
        }

        if ($view == Resource::Show) {
            $tags =  $this->tags()->get()->map(
                function (Tag $tag, int $index) {
                    return $tag->getData();
                }
            );
        };

        return match($view) {

            Resource::Index => [
                'title' => $this->title ,
                "rating" => $this->rating ,
                "id" => $this->id,
                "date_created" => $this->created_at->toDateString() ,
                "tags" => $tags,
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
                'tags' => $tags,
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

}
