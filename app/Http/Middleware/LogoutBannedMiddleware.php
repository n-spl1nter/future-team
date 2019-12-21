<?php

namespace App\Http\Middleware;

use App\Entities\User;
use Closure;
use Illuminate\Auth\AuthenticationException;

class LogoutBannedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        /** @var User|null $user */
        $user = $request->user();
        if ($user && $user->isBlocked()) {
            $user->token()->revoke();
            throw new AuthenticationException();
        }
        return $next($request);
    }
}
