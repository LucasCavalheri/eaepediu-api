<?php

namespace App\Http\Controllers\Complement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Complement\UploadComplementImageRequest;
use App\Http\Resources\ComplementResource;
use App\Models\Complement;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadComplementImageController extends Controller
{
    public function __invoke(UploadComplementImageRequest $request, int $id)
    {
        $complement = Complement::find($id);

        if (! $complement) {
            return $this->error('Complemento não encontrado', Response::HTTP_NOT_FOUND);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
            $filePath = 'complements/' . $complement->id . '/' . $fileName;

            $disk = config('app.env') === 'local' ? 'public' : 's3';

            $uploaded = Storage::disk($disk)->put($filePath, file_get_contents($file), 'public');

            if (! $uploaded) {
                return $this->error('Falha no upload da imagem.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            if ($complement->image_url && Storage::disk($disk)->exists($complement->image_url)) {
                Storage::disk($disk)->delete($complement->image_url);
            }

            $complement->update(['image_url' => $filePath]);

            return $this->success(
                'Imagem atualizada com sucesso!',
                Response::HTTP_OK,
                ComplementResource::make($complement)
            );
        }

        return $this->error('Imagem não encontrada', Response::HTTP_BAD_REQUEST);
    }
}
