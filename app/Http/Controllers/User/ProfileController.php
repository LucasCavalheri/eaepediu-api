<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        return $this->success('Perfil encontrado com sucesso!', Response::HTTP_OK, UserResource::make($request->user()));
    }
}
