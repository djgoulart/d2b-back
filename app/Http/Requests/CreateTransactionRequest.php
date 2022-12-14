<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account' => [
                'required',
                'uuid',
            ],
            'description' => [
                'required',
                'string',
            ],
            'type' => [
                'required',
                'string',
                Rule::in(['deposit', 'expense']),
            ],
            'amount' => [
                'required',
                'integer',
            ],
            'receipt' => [
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:2048',
                'required_unless:type,expense'
            ],
        ];
    }
}
