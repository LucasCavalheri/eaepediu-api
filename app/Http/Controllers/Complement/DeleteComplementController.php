<?php

namespace App\Http\Controllers\Complement;

use App\Http\Controllers\Controller;
use App\Models\Complement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeleteComplementController extends Controller
{
    public function __invoke(int $id): JsonResponse
    {
        $complement = Complement::find($id);

        if (! $complement) {
            return $this->error('Complemento não encontrado', Response::HTTP_NOT_FOUND);
        }

        $complement->delete();

        return $this->success('Complemento deletado com sucesso!', Response::HTTP_OK);
    }
}
