<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UploadUserImageRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UploadUserImageController extends Controller
{
    public function __invoke(UploadUserImageRequest $request)
    {
        // Valida a requisição
        $request->validated();

        /** @var User $user */
        $user = $request->user();

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = uniqid() . '.' . $file->getClientOriginalExtension(); // Gera um nome único
            $filePath = 'avatar/' . $user->id . '/' . $fileName;

            // Determina o disco a ser usado (local ou s3)
            $disk = config('app.env') === 'local' ? 'public' : 's3';

            /** @var \Illuminate\Filesystem\FilesystemManager $storage */
            $storage = Storage::disk($disk);

            // Realiza o upload da nova imagem
            $uploaded = $storage->put($filePath, file_get_contents($file), 'public');

            if (! $uploaded) {
                return $this->error('Falha no upload da imagem.', Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            // Exclui a imagem antiga se existir
            if ($user->avatar && $storage->exists($user->avatar)) {
                $storage->delete($user->avatar);  // Exclusão do arquivo anterior
            }

            // Atualiza o caminho RELATIVO da imagem no banco de dados
            $user->update(['avatar' => $filePath]);  // Salva apenas o caminho relativo

            // Retorna a resposta com sucesso
            return $this->success('Imagem atualizada com sucesso!', Response::HTTP_OK, UserResource::make($user));
        }

        return $this->error('Imagem não encontrada', Response::HTTP_BAD_REQUEST);
    }
}
