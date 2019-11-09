<?php

namespace App\Http\Middleware;

use App\Entities\User;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;

class CheckUserHasProfile
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws AuthenticationException
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next)
    {
        /** @var User | null $user */
        $user = $request->user();
        if (!$user) {
            throw new AuthenticationException();
        }
        if (!$user->hasFilledProfile()) {
            throw new AuthorizationException('No profile for current user');
        }
        return $next($request);
    }
}
