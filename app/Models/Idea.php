<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function data()
    {

        return[
            'title' => $this->title ,
            "rating" => $this->rating ,
            "id" => $this->id,
            /* "overview" => $this->overview , */
            /* "type" => $this->type , */
            /* "problem_to_solve" => $this->problem_to_solve , */
            /* "inspiration" => $this->inspiration , */
            /* "solution" => $this->solution , */
            /* "features" => $this->features , */
            /* "target_audience" => $this->target_audience , */
            /* "risks" => $this->risks , */
            /* "challenges" => $this->challenges , */
            "date_created" => $this->created_at->toDateString() ,
        ];
    }

}
