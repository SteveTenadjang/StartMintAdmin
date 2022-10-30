<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
                "email" => ['sometimes','email'],
                "password" => ['sometimes','string','confirmed','min:6'],
                "wallet_id" => ['sometimes','string'],
            ];
        }
        return [
            "name" => ['required','string'],
            "email" => ['required','email'],
            "password" => ['required','string','confirmed','min:6'],
            "wallet_id" => ['required','string'],
        ];
    }
}
