<?php

namespace App\Requests\Bookmark;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookmarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'max:120'],
            'description' => ['string', 'max:255'],
            'url' => ['string', 'url', 'max:255'],
            'tags' => ['array'],
            'tags.*.id' => ['exists:App\Models\Tag,id'],
        ];
    }
}
