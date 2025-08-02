<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIdeaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /* return false; */
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required','string'],
            "rating" =>  ['numeric'],
            "overview" => ['string','nullable'],
            "type" => ['string','nullable'],
            "problem_to_solve" => ['string','nullable'],
            "inspiration" => ['string','nullable'],
            "solution" => ['string','nullable'],
            "features" => ['string','nullable'],
            "target_audience" => ['string','nullable'],
            "risks" => ['string','nullable'],
            "challenges" => ['string','nullable'],
            "rating_questions" => ['array']
        ];
    }

    public function casts(): array
    {
        return [ ];
    }
}
