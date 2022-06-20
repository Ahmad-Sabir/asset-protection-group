<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return $user->hasVerifiedEmail()
        ? redirect()->intended(RouteServiceProvider::HOME) : view('auth.verify-email');
    }
}
