<?php

namespace App\Services;

use App\Mail\LoginCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class LoginVerification
{
    public const SESSION_KEY = 'login_verify';

    public const EXPIRES_MINUTES = 10;

    /**
     * Generate a fresh code, stash it in the session (hashed) and email it.
     */
    public function startFor(User $user, bool $remember = false): void
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        session([
            self::SESSION_KEY => [
                'user_id' => $user->id,
                'code_hash' => password_hash($code, PASSWORD_DEFAULT),
                'expires_at' => now()->addMinutes(self::EXPIRES_MINUTES)->getTimestamp(),
                'remember' => $remember,
            ],
        ]);

        Mail::to($user)->send(new LoginCodeMail($user, $code));
    }

    /**
     * The user awaiting verification, if any.
     */
    public function pendingUser(): ?User
    {
        $data = session(self::SESSION_KEY);

        if (! isset($data['user_id'])) {
            return null;
        }

        return User::find($data['user_id']);
    }

    public function remember(): bool
    {
        return (bool) (session(self::SESSION_KEY)['remember'] ?? false);
    }

    /**
     * Check the submitted code against the session-stored hash.
     */
    public function verify(string $code): bool
    {
        $data = session(self::SESSION_KEY);

        if (! isset($data['code_hash'], $data['expires_at'])) {
            return false;
        }

        if (now()->getTimestamp() > $data['expires_at']) {
            return false;
        }

        return password_verify($code, $data['code_hash']);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }
}
