<?php

namespace App\Requests\Bookmark;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookmarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:120'],
            'description' => ['string', 'max:255'],
            'url' => ['required', 'string', 'url', 'max:255'],
            'tags' => ['array'],
            'tags.*.id' => ['exists:App\Models\Tag,id'],
        ];
    }
}
