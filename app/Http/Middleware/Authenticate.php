<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            if ($request->is('vendor') || $request->is('vendor/*')) {
                return route('vendor.login');
            }

            if ($request->is('employee') || $request->is('employee/*')) {
                return route('employee.login');
            }
            if ($request->is('w2bcustomer') || $request->is('w2bcustomer/*')) {
                return route('w2bcustomer.login');
            }

            return route('login');
        }
    }
}
