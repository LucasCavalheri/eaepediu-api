<?php

namespace App\Http\Controllers\Complement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Complement\UpdateComplementRequest;
use App\Http\Resources\ComplementResource;
use App\Models\Complement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UpdateComplementController extends Controller
{
    public function __invoke(UpdateComplementRequest $request, int $id): JsonResponse
    {
        $complement = Complement::find($id);

        if (! $complement) {
            return $this->error('Complemento não encontrado', Response::HTTP_NOT_FOUND);
        }

        $complement->update($request->validated());

        return $this->success(
            'Complemento atualizado com sucesso!',
            Response::HTTP_OK,
            ComplementResource::make($complement)
        );
    }
}
