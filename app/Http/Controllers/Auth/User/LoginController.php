<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * @unauthenticated
     */
    public function __invoke(LoginRequest $request)
    {
        $data = $request->validated();

        if (! Auth::attempt($data)) {
            return $this->error('Credenciais inválidas', Response::HTTP_UNAUTHORIZED);
        }

        /** @var \App\Models\User */
        $user = Auth::user();
        $token = $user->createToken('access_token')->plainTextToken;

        return $this->success('Login realizado com sucesso!', Response::HTTP_OK, [
            'user' => UserResource::make($user),
            'token' => $token,
        ]);
    }
}
