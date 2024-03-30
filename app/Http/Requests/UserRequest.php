<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'document' => 'required|numeric|min:11|unique:users',
            'email' =>  'required|email|max:255|unique:users',
            'password' =>  'required|min:8'
        ];

        if($this->method() === "PATCH") {
            $rules = [
                'email' =>  'nullable|email|max:255|unique:users',
                'password' =>  'nullable|min:8',
                'status' => 'nullable'
            ];
        }
        
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'unique' => 'O campo :attribute já está em uso.',
            'name.min' => 'O campo nome necessita de pelo menos 3 caracteres.',
            'document.*' => 'Formato inválido para o campo documento.',
            'password.*' => 'A senha deve conter pelo menos 8 caracteres.',

        ];
    }
}