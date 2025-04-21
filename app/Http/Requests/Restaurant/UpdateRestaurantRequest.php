<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
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
            'name' => 'sometimes|string',

            'phone_number' => 'sometimes|string|min:13|max:14|regex:/^\+55/',

            'colors' => 'sometimes|array',
            'colors.primary' => 'sometimes|string',
            'colors.secondary' => 'sometimes|string',
            'colors.tertiary' => 'sometimes|string',

            'address' => 'sometimes|array',
            'address.street' => 'sometimes|string',
            'address.number' => 'sometimes|string',
            'address.neighborhood' => 'sometimes|string',
            'address.city' => 'sometimes|string',
            'address.state' => 'sometimes|string',
            'address.complement' => 'sometimes|string',
            'address.zip_code' => 'sometimes|string',

            'opening_hours' => 'sometimes|array',
            'opening_hours.normal' => 'sometimes|array',
            'opening_hours.normal.*.open' => 'required_with:opening_hours.normal|date_format:H:i',
            'opening_hours.normal.*.close' => 'required_with:opening_hours.normal|date_format:H:i',
            'opening_hours.special' => 'sometimes|array',
            'opening_hours.special.*.open' => 'required_with:opening_hours.special|date_format:H:i',
            'opening_hours.special.*.close' => 'required_with:opening_hours.special|date_format:H:i',
        ];
    }

    public function messages(): array
    {
        return [
            'opening_hours.normal.*.open.required_with' => 'O horário de abertura é obrigatório.',
            'opening_hours.normal.*.close.required_with' => 'O horário de fechamento é obrigatório.',
            'opening_hours.special.*.open.required_with' => 'O horário de abertura especial é obrigatório.',
            'opening_hours.special.*.close.required_with' => 'O horário de fechamento especial é obrigatório.',
            'opening_hours.*.open.date_format' => 'O horário de abertura deve estar no formato HH:mm.',
            'opening_hours.*.close.date_format' => 'O horário de fechamento deve estar no formato HH:mm.',
        ];
    }
}
