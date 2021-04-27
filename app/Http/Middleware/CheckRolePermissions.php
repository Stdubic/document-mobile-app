<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRolePermissions
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
		$user = Auth::user();

		if(!$user->active || !$user->canViewRoute($request->path(), $request->method()))
		{
			Auth::logout();
			return redirect(route('home'));
		}

        return $next($request);
    }
}
