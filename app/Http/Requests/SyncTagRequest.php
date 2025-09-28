<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncTagRequest extends FormRequest
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
            //
            /* 'tags' => ['array:key,value'], */
            'tags' => ['array'],
            'tags.*' => ['array:key,value'],
            'tags.*.key' => ['string'],
            'tags.*.value' => ['string'],
        ];
    }
}
