<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuste para implementar políticas de autorização
    }

    public function rules(): array
    {
        return [
            'status' => ['nullable', 'string', 'in:PENDING,CANCELED,DELIVERING,DELIVERED'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.in' => 'O status fornecido é inválido.',
            'discount.numeric' => 'O desconto deve ser numérico.',
            'tax.numeric' => 'O imposto deve ser numérico.',
        ];
    }
}
