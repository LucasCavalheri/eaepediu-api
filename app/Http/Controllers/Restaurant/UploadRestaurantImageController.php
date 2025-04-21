<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Http\Resources\RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadRestaurantImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $restaurant = Restaurant::find($id);

        if (! $restaurant) {
            return $this->error('Restaurante não encontrado.', Response::HTTP_NOT_FOUND);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension(); // Gera um nome único
            $filePath = 'restaurant/' . $restaurant->id . '/' . $fileName;

            $disk = config('app.env') === 'local' ? 'public' : 's3';

            $uploaded = Storage::disk($disk)->put($filePath, file_get_contents($file), 'public');

            if (! $uploaded) {
                return $this->error('Falha no upload da imagem.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($restaurant->photo_url && Storage::disk($disk)->exists($restaurant->photo_url)) {
                Storage::disk($disk)->delete($restaurant->photo_url);
            }

            $restaurant->update([
                'photo_url' => $filePath,
            ]);

            return $this->success('Imagem atualizada com sucesso!', Response::HTTP_OK, RestaurantResource::make($restaurant));
        }

        return $this->error('Imagem não encontrada', Response::HTTP_BAD_REQUEST);
    }
}

