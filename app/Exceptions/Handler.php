<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;    // ← Add this
use Illuminate\Support\Facades\Auth;   // ← And this
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Handle unauthenticated users (e.g. expired sessions).
     */
    protected function unauthenticated($request, AuthenticationException $exception): RedirectResponse
    {
        Log::warning('Unauthenticated access blocked', [
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'session_id' => session()->getId(),
            'guard' => $exception->guards(),
            'user_web' => Auth::guard('web')->user(),
            'user_guardian' => Auth::guard('guardian')->user(),
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Your session has expired.');
    }
}
