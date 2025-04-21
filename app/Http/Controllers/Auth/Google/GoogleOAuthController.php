<?php

namespace App\Http\Controllers\Auth\Google;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleOAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();


        $user = User::where('email', $googleUser->email)->first();

        if ($user) {
            $user->google_id = $googleUser->id;
            $user->avatar = $googleUser->avatar;
            if (! $user->email_verified_at) {
                $user->email_verified_at = now();
            }
            $user->save();
        } else {
            $user = User::create([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'avatar' => $googleUser->avatar,

                'password' => bcrypt(Str::random(12)),
                'email_verified_at' => now(),
            ]);
        }
        $token = $user->createToken('access_token')->plainTextToken;
        return redirect(config('app.frontend_url') . '/dashboard?token=' . $token);
    }
}
