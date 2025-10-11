<?php

namespace App\Services;

use App\Models\Idea;
use App\Models\Tag;

class IdeaCreatorService
{
    public function __construct(protected Idea $idea)
    {
    }

    public function createTags(array $tags): IdeaCreatorService
    {
        foreach ($tags as $tag_values) {
            $tag = Tag::firstOrCreate($tag_values);
            $this->idea->tags()->attach($tag);
        }

        return $this;
    }

    public function createRating(array $questions): IdeaCreatorService
    {
        if (sizeof($questions) == 1) {
            return $this;

        }
        //convert array to collection
        $questions = collect($questions);

        //get the total
        $questionTotal = $questions
            ->reduce(function ($sum, $cur) {
                return $sum *= $cur['score'];
            }, 1) ?? -1;



        //create the rating
        $rating = $this->idea->ratings()->create(['idea_id' => $this->idea->id, 'total_score' => $questionTotal]);

        //create all the answers
        $rating->ratingAnswers()->createMany($questions);

        return $this;

    }
}
