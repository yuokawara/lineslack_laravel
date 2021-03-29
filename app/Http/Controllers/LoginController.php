<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login()
    {
        return Socialite::driver('line-login')->with([
            'prompt' => 'consent',
            'bot_prompt' => 'normal',
        ])->redirect();
    }

    public function callback(Request $request)
    {
        if ($request->missing('code')) {
            dd($request);
        }

        /**
         * @var \Laravel\Socialite\Two\User
         */
        $user = Socialite::driver('line-login')->user();

        $loginUser = User::updateOrCreate([
            'name' => 'User',
            'avatar' => $user->avatar,
            'access_token' => $user->refreshToken,
        ]);

        auth()->login($loginUser, ture);
        return redirect()->route('home');
    }

    public function logout()
    {
        auth()->logout;
        return redirect('/');
    }
}
