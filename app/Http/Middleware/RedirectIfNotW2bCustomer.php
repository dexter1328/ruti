<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotW2bCustomer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = 'w2bcustomer')
	{
	    if (!Auth::guard($guard)->check()) {
	        return redirect('w2bcustomer/login');
	    }

	    return $next($request);
	}
}
