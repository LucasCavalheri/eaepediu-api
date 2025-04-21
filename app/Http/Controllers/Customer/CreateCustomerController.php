<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Restaurant;
use Illuminate\Http\Response;

class CreateCustomerController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateCustomerRequest $request)
    {
        $data = $request->validated();

        $restaurant = Restaurant::find($data['restaurant_id']);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        $customer = $restaurant->customers()->create($data);

        return $this->success('Cliente registrado com sucesso!', Response::HTTP_CREATED, CustomerResource::make($customer));
    }
}
