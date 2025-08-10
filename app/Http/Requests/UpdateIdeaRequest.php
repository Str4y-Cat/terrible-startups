<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIdeaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
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
            'title' => ['string',"max:255"],
            "rating" =>  ['numeric'],
            "overview" => ['string','nullable', 'max:10000'],
            "type" => ['string','nullable', 'max:10000'],
            "problem_to_solve" => ['string','nullable', 'max:10000'],
            "inspiration" => ['string','nullable', 'max:10000'],
            "solution" => ['string','nullable', 'max:10000'],

            'features'          => ['array'],
            'features.*'        => ['string', 'max:255'], // each feature must be a string

            'target_audience'   => ['array'],
            'target_audience.*' => ['string', 'max:255'],

            'risks'             => ['array'],
            'risks.*'           => ['string', 'max:255'],

            'challenges'        => ['array'],
            'challenges.*'      => ['string', 'max:255'],
        ];
    }
}
