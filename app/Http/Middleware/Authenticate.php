<?php

protected function redirectTo($request)
{
    if (! $request->expectsJson()) {
        return route('/'); // make sure this route exists
    }
}