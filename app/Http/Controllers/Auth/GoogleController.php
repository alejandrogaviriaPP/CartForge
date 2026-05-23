<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
      /** @var \Laravel\Socialite\Two\AbstractProvider $provider */
    $provider = Socialite::driver('google');

    $googleUser = $provider->stateless()->user();
        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'password' => bcrypt(Str::random(24)),
                'email_verified_at' => now(),
            ]
        );

        if ($user->wasRecentlyCreated) {
            Mail::raw('Welcome! Your account was created with Google.', function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Welcome to CartForge');
            });
        }

        Auth::login($user);

        return redirect('/products');
    }
}
