<?php

namespace App\Http\Requests\Client\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'order_id' => 'required|array',
            'course_ids.*' => 'required|integer|exists:courses,id'
        ];
    }
}
