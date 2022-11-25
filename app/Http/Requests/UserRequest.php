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
                "name" => ['sometimes','string','unique:users','name,'.$this['id']],
                "email" => ['sometimes','email','unique:users','email,'.$this['id']],
                "password" => ['sometimes','string','confirmed','min:6'],
                "wallet" => ['sometimes','string'],
                'bundle_id' => ['sometimes','integer']
            ];
        }
        return [
            "name" => ['required','string','unique:users'],
            "email" => ['required','email','unique:users'],
            "password" => ['required','string','confirmed','min:6'],
            "wallet" => ['required','string'],
            'bundle_id' => ['integer']
        ];
    }
}
