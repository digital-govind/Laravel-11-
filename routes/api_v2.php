<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redis;



Route::get('users', function () {
    return "Govind Kumar";
});

Route::get('/version', function () {
    // Setting a value in Redis
    Redis::set('api_v2', 'Testing api version 2');

    // Retrieving the value from Redis
    $value = Redis::get('api_v2');

    // Return the value as JSON response
    return response()->json(['Redis Test Value' => $value]);
});
