<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Les middlewares globaux.
     *
     * @var array
     */
    protected $middleware = [
        // Middlewares globaux ici
        
    ];
       
   

    /**
     * Les groupes de middleware.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // Middlewares pour le groupe web ici
            \Illuminate\Auth\Middleware\Authenticate::class,
        ],

        'api' => [
            // Middlewares pour le groupe API ici
        ],
    ];

    /**
     * Les middlewares individuels.
     *
     * @var array
     */
    protected $routeMiddleware = [
        // Middlewares individuels ici
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'checkRrole' => \App\Http\Middleware\CheckRole::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \Illuminate\Auth\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
