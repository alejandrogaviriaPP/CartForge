<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'password' => bcrypt(Str::random(24)),
            'email_verified_at' => now(),
        ]
    );

    // 🔥 detectar si es nuevo usuario
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