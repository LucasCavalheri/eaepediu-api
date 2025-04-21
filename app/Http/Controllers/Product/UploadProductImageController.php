<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\UploadProductImageRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadProductImageController extends Controller
{
    public function __invoke(UploadProductImageRequest $request, int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return $this->error('Produto não encontrado', Response::HTTP_NOT_FOUND);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = 'products/' . $product->id . '/' . $fileName;

            $disk = config('app.env') === 'local' ? 'public' : 's3';

            $uploaded = Storage::disk($disk)->put($filePath, file_get_contents($file), 'public');

            if (!$uploaded) {
                return $this->error('Falha no upload da imagem.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($product->image_url && Storage::disk($disk)->exists($product->image_url)) {
                Storage::disk($disk)->delete($product->image_url);
            }

            $product->update(['image_url' => $filePath]);

            return $this->success(
                'Imagem do produto atualizada com sucesso!',
                Response::HTTP_OK,
                ProductResource::make($product)
            );
        }

        return $this->error('Imagem não encontrada', Response::HTTP_BAD_REQUEST);
    }
}
