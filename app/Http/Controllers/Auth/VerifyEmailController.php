<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  \App\Http\Requests\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        /** @var User $user */
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }

        if ($user->markEmailAsVerified()) {
             /** @phpstan-ignore-next-line */
            event(new Verified($request->user()));
        }

        return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
    }
}
