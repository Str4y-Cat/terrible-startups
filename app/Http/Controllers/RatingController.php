<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateRatingRequest;
use App\Models\Idea;

class RatingController extends Controller
{
    //SWOT ANALYSIS
    public function update(Idea $idea, UpdateRatingRequest $request)
    {
        $rating = $idea->ratings()->first();
        $newAnswers = collect($request->validated()['rating_answers']);

        $currentAnswers = $rating->ratingAnswers;

        $currentAnswers->map(function ($answer) use ($newAnswers) {
            $question_id = $answer->question_id;

            $newAnswer = $newAnswers->first(function ($answer) use ($question_id) {
                return $answer['question_id'] == $question_id;
            });

            $answer->update($newAnswer);

        });

        return back()->with('success', 'Rating updated.');
    }

}
