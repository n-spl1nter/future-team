<?php

namespace App\Http\Middleware;

use App\Entities\User;
use Closure;

class LogoutBannedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User|null $user */
        $user = $request->user();
        if ($user && $user->isBlocked()) {
            \Auth::logout();
        }
        return $next($request);
    }
}
