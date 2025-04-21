<?php

namespace App\Http\Controllers\Complement;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComplementResource;
use App\Models\Complement;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FindRestaurantComplementsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $restaurant = Restaurant::find($id);

        if (!$restaurant) {
            return $this->error('Restaurante não encontrado', Response::HTTP_NOT_FOUND);
        }

        // Acessa os complements via relacionamento indireto
        // $complements = $restaurant->products() // Primeiro acessa os produtos
        //     ->with('complements') // Carrega os complements relacionados
        //     ->get()
        //     ->pluck('complements') // Extrai apenas os complements
        //     ->flatten() // Achata a coleção de coleções
        //     ->unique('id'); // Remove duplicatas (opcional)


        // query mais otimizada
        $complements = Complement::whereHas('product', function($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->get();

        if ($complements->isEmpty()) {
            return $this->error('Nenhum complemento encontrado', Response::HTTP_NOT_FOUND);
        }

        return $this->success(
            'Complementos encontrados com sucesso!',
            Response::HTTP_OK,
            ComplementResource::collection($complements)
        );
    }
}
