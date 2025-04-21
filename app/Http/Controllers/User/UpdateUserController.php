<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;

class UpdateUserController extends Controller
{
    public function __invoke(UpdateUserRequest $request)
    {
        $data = $request->validated();

        $user = $request->user();

        if (isset($data['email']) && $data['email'] !== $user->email) {
            // Atualiza o e-mail e reseta a verificação
            $user->update([
                'email' => $data['email'],
                'email_verified_at' => null, // Reseta a verificação
            ]);

            // Envia a notificação de verificação de e-mail
            $user->sendEmailVerificationNotification();
        } else {
            $user->update($data);
        }

        return $this->success('Usuário atualizado com sucesso!', Response::HTTP_OK, UserResource::make($user));
    }
}
