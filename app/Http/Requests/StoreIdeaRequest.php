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
            "overview" => ['string','nullable', 'max:10000'],
            "type" => ['string','nullable', 'max:10000'],
            "problem_to_solve" => ['string','nullable', 'max:10000'],
            "inspiration" => ['string','nullable', 'max:10000'],
            "solution" => ['string','nullable', 'max:10000'],
            "features" => ['string','nullable', 'max:10000'],
            "target_audience" => ['string','nullable', 'max:10000'],
            "risks" => ['string','nullable', 'max:10000'],
            "challenges" => ['string','nullable', 'max:10000'],
            "rating_questions" => ['array']
        ];
    }

    public function casts(): array
    {
        return [ ];
    }
}
