<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UpdateCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateCategoryRequest $request, string $id)
    {
        $data = $request->validated();

        $restaurant = $request->user()->restaurant;

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Verifica se a categoria pertence ao restaurante do usuário
        $category = $restaurant->categories()->find($id);

        if (! $category) {
            return $this->error('Categoria não encontrada', Response::HTTP_NOT_FOUND);
        }

        $category->update($data);

        return $this->success('Categoria atualizada com sucesso!', Response::HTTP_OK, CategoryResource::make($category));
    }
}
