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
                "contract_address" => ['sometimes','string'],
                "wallet" => ['sometimes','string'],
                "token" => ['sometimes','string'],
                "media_link" => ['sometimes','string'],
                "media_type" => ['sometimes','string'],
                "media_title" => ['sometimes','string'],
                "nft_quantity" => ['sometimes','integer','min:1','max:25'],
                "price" => ['sometimes','numeric'],
                "description" => ['sometimes','string'],
                "blockchain_type" => ['sometimes','string'],
            ];
        }
        return [
            "author_name" => ['required','string'],
            "contract_address" => ['required','string'],
            "wallet" => ['required','string'],
            "token" => ['required','string'],
            "media_link" => ['required','string'],
            "media_type" => ['required','string'],
            "media_title" => ['required','string'],
            "nft_quantity" => ['required','integer','min:1',' max:25'],
            "description" => ['string'],
            "blockchain_type" => ['required','string'],
            "price" => ['required','numeric'],
        ];
    }
}
