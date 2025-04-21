<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DeleteCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $restaurant = $request->user()->restaurant;

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Verifica se a categoria pertence ao restaurante do usuário
        $category = $restaurant->categories()->find($id);

        if (! $category) {
            return $this->error('Categoria não encontrada', Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        return $this->success('Categoria excluída com sucesso!', Response::HTTP_OK);
    }
}
