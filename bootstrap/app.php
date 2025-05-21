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
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $exception, \Illuminate\Http\Request $request) {
            \Illuminate\Support\Facades\Log::warning('Unauthenticated access blocked', [
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'session_id' => session()->getId(),
                'guard' => $exception->guards(),
                'user_web' => \Illuminate\Support\Facades\Auth::guard('web')->user(),
                'user_guardian' => \Illuminate\Support\Facades\Auth::guard('guardian')->user(),
            ]);

            return redirect()
                ->route('home')
                ->with('success', 'Your session has expired. Please log in again.');
        });
    })
    ->create();
