<?php

namespace App\Requests\Bookmark;

use Illuminate\Foundation\Http\FormRequest;

class ListBookmarkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tag' => ['string'],
            'visited_only' => ['boolean'],
            'search_by' => ['string'],
            'sort_by' => ['string', 'in:visited_at,created_at'],
            'sort_direction' => ['string', 'in:asc,desc'],
            'per_page' => ['integer', 'min:15', 'max:50'],
        ];
    }
}
