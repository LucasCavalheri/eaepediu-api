<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindAllRestaurantCustomersController extends Controller
{
    public function __invoke(Request $request, string $id)
    {
        $restaurant = $request->user()->restaurants()->find($id);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        $customers = $restaurant->customers()->get();

        return $this->success('Clientes encontrados com sucesso!', Response::HTTP_OK, CustomerResource::collection($customers));
    }
}
