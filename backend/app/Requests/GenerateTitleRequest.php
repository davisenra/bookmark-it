<?php

namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateTitleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => ['required', 'string', 'url', 'max:255'],
        ];
    }
}
