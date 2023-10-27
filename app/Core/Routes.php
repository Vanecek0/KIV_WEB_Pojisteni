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
    "/login" => [Auth::class, "index"],
    "/login/post" => [Login::class, "handleLogin"],
    "/logout" => [Login::class, "handleLogout"],
    "/register" => [Auth::class, "signUpPage"],
    "/register/post" => [Auth::class, "handleRegister"],
 ];
