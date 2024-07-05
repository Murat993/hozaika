<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthorizationException;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->isAdmin()) return $next($request);

        if (!Auth::check() || !$user->hasRole($role)) {
            throw new AuthorizationException();
        }

        return $next($request);
    }
}
