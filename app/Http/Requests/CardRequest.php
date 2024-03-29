<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'number' => 'required|min:16',
            'expire_date' => 'required|min:5',
            'cvc' => 'required|max:4',
            'name' => 'required|min:3|max:255',
            'limit_balance' => 'required|min:0',
            'current_balance' => 'required|min:0'
        ];

        if($this->method() === "PATCH") {
            $rules = [
                'current_balance' => 'required|min:0'
            ];
        }
        
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório'
        ];
    }
}
