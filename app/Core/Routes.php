<?php
namespace App\Core;

use App\Controllers\Auth;
use App\Controllers\Home;
use App\Controllers\User;

return [ 
    "/" => [Home::class, 'index'],
    "/home" => [Home::class, "index"],
    "/user" => [User::class, "index"],
    "/user/(:any)" => [User::class, "getUser"],
    "/user/test/(:any)" => [User::class, "getUser"],
    "/login" => [Auth::class, "index", "guest_only", "/"],
    "/login/post" => [Auth::class, "credentialLogin", "guest_only", "/login"],
    "/logout" => [Auth::class, "logout", "auth_only", "/login"],
    "/register" => [Auth::class, "signUpPage", "guest_only"],
    "/register/post" => [Auth::class, "handleRegister", "guest_only"],
 ];
