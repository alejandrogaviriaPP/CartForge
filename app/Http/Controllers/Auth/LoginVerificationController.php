<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\LoginVerification;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LoginVerificationController extends Controller
{
    public function __construct(protected LoginVerification $verification) {}

    public function show(Request $request): View|RedirectResponse
    {
        $user = $this->verification->pendingUser();

        if (! $user) {
            return redirect()->route('login');
        }

        return view('auth.verify-code', ['email' => $user->email]);
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'digits:6'],
        ]);

        if (! $this->verification->verify($request->code)) {
            throw ValidationException::withMessages([
                'code' => __('login_code.invalid'),
            ]);
        }

        $user = $this->verification->pendingUser();
        $remember = $this->verification->remember();

        Auth::login($user, $remember);

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        $this->verification->clear();
        $request->session()->regenerate();

        return redirect()->route('home')
            ->with('status', __('welcome_back'));
    }

    public function resend(Request $request): RedirectResponse
    {
        $user = $this->verification->pendingUser();

        if ($user) {
            $this->verification->startFor($user, $this->verification->remember());
        }

        return back()->with('status', __('login_code.resent'));
    }
}
