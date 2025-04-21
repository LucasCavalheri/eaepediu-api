<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Response;

class CreateCategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(CreateCategoryRequest $request, $id)
    {
        $data = $request->validated();

        $restaurant = $request->user()->restaurants()->find($id);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        $category = $restaurant->categories()->create($data);

        return $this->success('Categoria cadastrada com sucesso!', Response::HTTP_CREATED, CategoryResource::make($category));
    }
}
