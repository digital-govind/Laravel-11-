<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
    return view('welcome');
});

Route::get('users', function () {
    return "Maja";
});

Route::get('/test-redis1', function () {
    // Setting a value in Redis
    Redis::set('test_key', 'test_value');

    // Retrieving the value from Redis
    $value = Redis::get('test_key');

    // Return the value as JSON response
    return response()->json(['Redis Test Value' => $value]);
});
