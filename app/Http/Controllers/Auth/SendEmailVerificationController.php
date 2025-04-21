<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SendEmailVerificationController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if (! $user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            return $this->success('Email de verificação enviado com sucesso!', Response::HTTP_OK);
        }

        return $this->error('Email já verificado!', Response::HTTP_BAD_REQUEST);
    }
}
