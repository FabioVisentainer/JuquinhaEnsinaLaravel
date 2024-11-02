<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProductRequest extends FormRequest
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
        return [
            //requisres e max lengh de 100
            'name' => 'required|max:100',
            // min de 3 caso não for nulo
            'descriptions' => 'nullable|min:3',
            //obrigatório, decimal com 2 casas apos a virgula, e valor máximo 100
            'size' => 'required|decimal:0,2|max:100',
        ];
    }

    
}
