<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingRequest extends FormRequest
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
            'rating_answers'  => ['array','nullable'],
            'rating_answers.*' => ['array:question_id,score'],
            'rating_answers.*.key' => ['numeric'],
            'rating_answers.*.value' => ['numeric'],
        ];
    }
}
