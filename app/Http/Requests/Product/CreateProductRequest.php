<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Regras de validação para criação de Product.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|string|url',
            'is_available' => 'required|boolean',
            'category_id' => 'required|integer|exists:categories,id',
        ];
    }

    /**
     * Mensagens de erro personalizadas (opcional).
     */
    // public function messages(): array
    // {
    //     return [
    //         'name.required' => 'O campo nome é obrigatório.',
    //         'name.unique' => 'Já existe um item de menu com esse nome.',
    //         'price.required' => 'O campo preço é obrigatório.',
    //         'price.numeric' => 'O preço deve ser um número.',
    //         'category_ids.required' => 'É necessário associar ao menos uma categoria.',
    //         'category_ids.*.exists' => 'Uma ou mais categorias não existem.',
    //     ];
    // }
}
