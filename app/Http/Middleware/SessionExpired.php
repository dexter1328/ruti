<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Session;

class SessionExpired
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*protected $session;
    protected $timeout=900;*/
   /* public function __construct(Store $session){
        $this->session=$session;
    }*/
    

    public function handle($request, Closure $next)
    {
        Session::put('userLastActivity', date('U'));
      
       /* Session::forget('idleWarningDisplayed');*/
        Session::forget('logoutWarningDisplayed');

        return $next($request);
    }

   /* protected function getTimeOut()
    {
        return (config('session.lifetime')) ?: $this->timeout;
    }*/
}
