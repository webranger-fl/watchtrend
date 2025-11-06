<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
      $middleware->alias([
          'loadCache' => \App\Http\Middleware\LoadCache::class,
          'cacheAfter' => \App\Http\Middleware\CacheAfter::class,
          'logPerfomance' => \App\Http\Middleware\LogPerfomance::class,
          'app' => \App\Http\Middleware\App::class,
      ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
      // чтобы пользователи гости которые стучат в админки редиректились на главную
      $middleware->redirectGuestsTo('/');
  
      // Using a closure...
      //$middleware->redirectGuestsTo(fn (Request $request) => route('login'));
    })
    /*->withMiddleware(function (Middleware $middleware) {
        //
    })*/
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
