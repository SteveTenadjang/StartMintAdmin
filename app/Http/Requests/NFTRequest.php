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
                "nft_quantity" => ['sometimes','integer','min:1','max:25'],
                "price" => ['sometimes','numeric'],
                "description" => ['sometimes','string'],
                "blockchain_type" => ['sometimes','string'],
                "file" => ['sometimes','mimes:mp4,mov,gif,jpg,png,pdf,ai,eps,mp3,wav,aiff','max:5120']
            ];
        }
        return [
            "author_name" => ['required','string'],
            "contract_address" => ['required','string'],
            "wallet" => ['required','string'],
            "token" => ['required','string'],
            "nft_quantity" => ['required','integer','min:1',' max:25'],
            "description" => ['string'],
            "blockchain_type" => ['required','string'],
            "price" => ['required','numeric'],
            "file" => ['required','mimes:mp4,mov,gif,jpg,png,pdf,ai,eps,mp3,wav,aiff','max:5120']
        ];
    }
}
