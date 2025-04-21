<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255|unique:products,name,'.$this->route('id'),
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'image_url' => 'nullable|string|url',
            'is_available' => 'sometimes|boolean',
            'category_id' => 'sometimes|integer|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Já existe um produto com este nome.',
            'category_id.exists' => 'A categoria selecionada não existe.',
        ];
    }
}
