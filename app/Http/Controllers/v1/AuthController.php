<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    public function register(){
        return "Test register";
    }

    public function login(){
        return "Login user";
    } 
}
