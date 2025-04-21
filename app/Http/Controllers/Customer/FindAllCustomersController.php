<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindAllCustomersController extends Controller
{
    public function __invoke(Request $request)
    {
        return $this->success('Clientes encontrados com sucesso!', Response::HTTP_OK, CustomerResource::collection(Customer::with('restaurant')->get()));
    }
}
