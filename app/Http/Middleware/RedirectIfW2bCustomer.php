<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfW2bCustomer
{
    /**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = 'w2bcustomer')
	{
	    if (Auth::guard($guard)->check()) {
	        return redirect('/');
	    }

	    return $next($request);
	}
}
