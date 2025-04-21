<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        $token = $request->query('token');

        if (! $token) {
            return $this->error('Token não fornecido', Response::HTTP_BAD_REQUEST);
        }

        $record = DB::table('email_verifications')
            ->where('token', hash('sha256', $token))
            ->where('expires_at', '>', now())
            ->first();

        if (! $record) {
            return $this->error('Token inválido ou expirado', Response::HTTP_BAD_REQUEST);
        }

        // Marca o e-mail como verificado
        $user = User::where('email', $record->email)->first();

        if ($user) {
            $user->update(['email_verified_at' => now()]);

            // Remove o token do banco
            DB::table('email_verifications')->where('email', $record->email)->delete();

            return $this->success('E-mail verificado com sucesso!', Response::HTTP_OK);
        }

        return $this->error('Usuário não encontrado', Response::HTTP_NOT_FOUND);
    }
}
