<?php
namespace App\Core;

use App\Controllers\Home;
use App\Controllers\User;

return [ 
    "/" => [Home::class, "index"],
    "/home" => [Home::class, "index"],
    "/user" => [Home::class, "index"],
    "/user/(:any)" => [User::class, "getUser"],
    "/user/test/(:any)" => [User::class, "getUser"]
 ];
