<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NFTRequest extends FormRequest
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
                "author_name" => ['sometimes','string'],
                "media_link" => ['sometimes','string'],
                "media_type" => ['sometimes','string'],
                "price" => ['sometimes','decimal'],
                "description" => ['sometimes','string'],
                "blockchain_type" => ['sometimes','string'],
                "title" => ['sometimes','string'],
                "created_by" => ['sometimes','integer','exists:users,id'],
                "max_quantity" => ['sometimes','integer','min:1'],
                "limit" => ['sometimes','integer','min:1'],
            ];
        }
        return [
            "author_name" => ['required','string'],
            "media_link" => ['required','string'],
            "media_type" => ['required','string'],
            "title" => ['required','string'],
            "description" => ['string'],
            "blockchain_type" => ['required','string'],
            "created_by" => ['required','integer','exists:users,id'],
            "price" => ['required','decimal'],
            "max_quantity" => ['required','integer','min:1'],
            "limit" => ['required','integer','min:1'],
        ];
    }
}
