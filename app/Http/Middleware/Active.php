<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Active
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
       /** @var User $user */
        $user = $request->user();
        if ($user->company()->whereNotNull('deactivate_at')->exists()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('login')->withErrors([trans('auth.company')])->withInput();
        }
        if (! is_null($user->deactivate_at)) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('login')->withErrors([trans('auth.active')])->withInput();
        }
        return $next($request);
    }
}
