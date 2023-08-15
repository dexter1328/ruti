<?php

namespace App\Http;

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\RedirectIfAdmin;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\RedirectIfEmployee;
use App\Http\Middleware\RedirectIfNotAdmin;
use App\Http\Middleware\RedirectIfNotEmployee;
use App\Http\Middleware\RedirectIfNotSupplier;
use App\Http\Middleware\RedirectIfNotVendor;
use App\Http\Middleware\RedirectIfNotW2bCustomer;
use App\Http\Middleware\RedirectIfSupplier;
use App\Http\Middleware\RedirectIfVendor;
use App\Http\Middleware\RedirectIfW2bCustomer;
use App\Http\Middleware\SessionExpired;
use App\Http\Middleware\SupplierChecklist;
use App\Http\Middleware\VendorChecklist;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \AppSeeds\DeferLaravel\DeferMiddleware::class,
        \App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        // \Spatie\Cors\Cors::class,
        // \App\Http\Middleware\ForceJsonResponse::class,
        // \App\Http\Middleware\Cors::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'employee' => RedirectIfNotEmployee::class,
        'employee.guest' => RedirectIfEmployee::class,
        'vendor' => RedirectIfNotVendor::class,
        'vendor.guest' => RedirectIfVendor::class,
        'supplier' => RedirectIfNotSupplier::class,
        'supplier.guest' => RedirectIfSupplier::class,
        'w2bcustomer' => RedirectIfNotW2bCustomer::class,
        'w2bcustomer.guest' => RedirectIfW2bCustomer::class,
        'admin' => RedirectIfNotAdmin::class,
        'admin.guest' => RedirectIfAdmin::class,
        'auth' => Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'sessionExpired' => SessionExpired::class,
        'vendorChecklist' => VendorChecklist::class,
        'supplierChecklist' => SupplierChecklist::class,
        // 'json.response' => \App\Http\Middleware\ForceJsonResponse::class,
        // 'cors' => \App\Http\Middleware\Cors::class,
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\Authenticate::class,
        \Illuminate\Session\Middleware\AuthenticateSession::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
        \Illuminate\Auth\Middleware\Authorize::class,
    ];
}
