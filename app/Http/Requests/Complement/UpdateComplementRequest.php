<?php

namespace App\Http\Requests\Complement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComplementRequest extends FormRequest
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
            'name' => 'sometimes|string|max:100',
            'price' => 'sometimes|numeric|min:0',
            'product_id' => 'sometimes|integer|exists:products,id',
        ];
    }
}
