<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class CreateRestaurantRequest extends FormRequest
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
            'subdomain' => 'required|string|alpha_dash|max:100|unique:restaurants',
            'name' => 'required|string',
            'phone_number' => 'required|string|min:13|max:14|regex:/^\+55/',
            'address' => 'required|array',
            'address.street' => 'required|string',
            'address.number' => 'required|string',
            'address.neighborhood' => 'required|string',
            'address.city' => 'required|string',
            'address.state' => 'required|string',
            'address.zip_code' => 'required|string',
            'address.complement' => 'sometimes|string',
        ];
    }
}
