<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'phone_number' => 'sometimes|string|min:13|max:14|regex:/^\+55/|unique:customers,phone_number,'.$this->customer->id,
            'address' => 'sometimes|array',
            'address.number' => 'sometimes|string',
            'address.neighborhood' => 'sometimes|string',
            'address.city' => 'sometimes|string',
            'address.state' => 'sometimes|string',
            'address.zip_code' => 'sometimes|string',
            'address.complement' => 'sometimes|string',
        ];
    }
}
