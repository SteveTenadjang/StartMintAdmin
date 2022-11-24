<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BundleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    { return true; }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            return [
                "name" => ['sometimes','string'],
                "limit" => ['sometimes','integer','min:1'],
                "duration" => ['sometimes','integer','min:1'],
            ];
        }
        return [
            "name" => ['required','string'],
            "limit" => ['required','integer','min:1'],
            "duration" => ['required','integer','min:1'],
        ];
    }
}
