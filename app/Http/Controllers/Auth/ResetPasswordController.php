<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /**
     * @unauthenticated
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'token' => 'required|integer|min:6',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $isTokenValid = DB::table('password_resets')
            ->where('token', $request->input('token'))
            ->where('expires_at', '>', now())
            ->first();

        if (! $isTokenValid) {
            return $this->error('Token inválido ou expirado', Response::HTTP_BAD_REQUEST);
        }

        $user = User::find($isTokenValid->user_id);

        if (! $user) {
            return $this->error('Usuário não encontrado', Response::HTTP_NOT_FOUND);
        }

        $user->update([
            'password' => bcrypt($request->input('password')),
        ]);

        DB::table('password_resets')->where('user_id', $user->id)->orWhere('token', $request->input('token'))->delete();

        return $this->success('Senha alterada com sucesso!', Response::HTTP_OK);
    }
}
