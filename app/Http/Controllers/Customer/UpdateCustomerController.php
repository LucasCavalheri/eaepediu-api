<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Response;

class UpdateCustomerController extends Controller
{
    public function __invoke(UpdateCustomerRequest $request, string $id)
    {
        $data = $request->validated();

        $customer = Customer::find($id);

        if (! $customer) {
            return $this->error('Cliente nao encontrado', Response::HTTP_NOT_FOUND);
        }

        $customer->update($data);

        return $this->success('Cliente atualizado com sucesso!', Response::HTTP_OK, CustomerResource::make($customer));
    }
}
