<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserBundleRequest extends FormRequest
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
                "user_id" => ['sometimes','integer','exists:users,id'],
                "bundle_id" => ['sometimes','integer','exists:bundles,id'],
            ];
        }
        return [
            "user_id" => ['required','integer','exists:users,id'],
            "bundle_id" => ['required','integer','exists:bundles,id'],
        ];
    }
}
