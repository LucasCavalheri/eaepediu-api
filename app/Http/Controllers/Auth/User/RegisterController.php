<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    /**
     * @unauthenticated
     */
    public function __invoke(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        $user->sendEmailVerificationNotification();

        return $this->success('Cadastro realizado com sucesso!', Response::HTTP_CREATED, UserResource::make($user));
    }
}
