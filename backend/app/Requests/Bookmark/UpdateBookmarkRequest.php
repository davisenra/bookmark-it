<?php

namespace App\Requests\Bookmark;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookmarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['string', 'max:120'],
            'description' => ['max:255'],
            'tags' => ['array'],
            'tags.*.id' => ['exists:App\Models\Tag,id'],
        ];
    }
}
