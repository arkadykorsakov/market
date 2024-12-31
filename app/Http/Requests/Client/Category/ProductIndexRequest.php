<?php

namespace App\Http\Requests\Client\Category;

use Illuminate\Foundation\Http\FormRequest;

class ProductIndexRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'integer' => 'nullable|array',
            'checkbox' => 'nullable|array',
            'select' => 'nullable|array',
        ];
    }
}
