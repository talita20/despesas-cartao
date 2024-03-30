<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'name' => 'required|min:3|max:255',
            'number' => 'required|unique:cards|min:13|max:16',
            'expire_date' => 'required|min:5',
            'cvc' => 'required|numeric',
            'limit_balance' => 'required|numeric|gte:0',
            'current_balance' => 'required|numeric|gte:0'
        ];

        if($this->method() === "PATCH") {
            $rules = [
                'current_balance' => 'required|numeric|gte:0'
            ];
        }

        $rules['user_id'] = [
            'required',
            Rule::exists('users', 'id')->where('id', $this->user_id)
        ];
        
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O campo :attribute já está em uso.',
            'number.*' => 'Formato inválido do campo :attribute.',
            'gte' => 'O campo :attribute deve ser maior ou igual a zero.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'user_id.*' => 'Usuário não encontrado com o id informado.'
        ];
    }
}
