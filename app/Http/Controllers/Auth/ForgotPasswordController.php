<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ForgotPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    /**
     * @unauthenticated
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            // 'identifier' => 'required|string', // Pode ser e-mail ou número de telefone
            // 'method' => 'required|string|in:email,sms', // Define o método de recuperação
        ]);

        // $user = User::where('email', $request->input('identifier'))->orWhere('phone', $request->input('identifier'))->first();

        $user = User::where('email', $request->input('email'))->first();

        if (! $user) {
            return $this->error('Usuário não encontrado', Response::HTTP_NOT_FOUND);
        }

        // gera um token de 6 digitos inteiros aleatórios
        $token = rand(100000, 999999);

        DB::table('password_resets')->insert([
            'token' => $token,
            'user_id' => $user->id,
            'expires_at' => now()->addMinutes(15),
        ]);

        $notification = new ForgotPasswordNotification($token, config('app.frontend_url'));

        $user->notify($notification);

        return $this->success('Token enviado com sucesso!', Response::HTTP_OK);
    }
}
