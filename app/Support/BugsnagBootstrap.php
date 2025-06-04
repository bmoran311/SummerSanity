<?php

use Bugsnag\Client;
use Bugsnag\Handler;

// Only init in non-local environments if you want
$bugsnag = Client::make(env('BUGSNAG_API_KEY', 'e7dfeefdb856e5b72d124560046906df'));
Handler::register($bugsnag);

// Optional: add user info
if (auth()->check()) {
    $bugsnag->setUser(auth()->id(), auth()->user()->email, null);
}
