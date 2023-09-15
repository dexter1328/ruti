<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        // parent::report($exception);
        if ($this->shouldReport($exception) && app()->bound('sentry')) {
            app('sentry')->captureException($exception);
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof TokenMismatchException) {
             // Get the current guard name
            $guardName = Auth::getDefaultDriver();

            if (Auth::guard('w2bcustomer')) {
                return redirect()->route('w2bcustomer.login');
            } elseif (Auth::guard('vendor')) {
                return redirect()->route('vendor.login');
            } elseif (Auth::guard('vendor')) {
                return redirect()->route('supplier.login');
            } else {
                // Add more conditions for other guards as needed
                return redirect()->route('admin.login');
            }
        }
        else
        {
            return parent::render($request, $exception);
        }
    }
}
