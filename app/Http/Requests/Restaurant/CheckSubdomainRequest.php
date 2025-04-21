<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class CheckSubdomainRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subdomain' => 'required|string|min:5|max:50|alpha_dash',
        ];
    }

    public function messages(): array
    {
        return [
            'subdomain.required' => 'O subdomínio é obrigatório.',
            'subdomain.string' => 'O subdomínio deve ser uma string.',
            'subdomain.min' => 'O subdomínio deve ter no mínimo 5 caracteres.',
            'subdomain.max' => 'O subdomínio deve ter no máximo 50 caracteres.',
            'subdomain.alpha_dash' => 'O subdomínio deve conter apenas letras, números, underscores ou hífens.',
        ];
    }
}
