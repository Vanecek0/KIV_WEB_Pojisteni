<?php
namespace App\Core;

use App\Controllers\Auth;
use App\Controllers\Contract;
use App\Controllers\Home;
use App\Controllers\Portal;
use App\Controllers\User;

return [ 
    "/" => [Home::class, 'index'],
    "/home" => [Home::class, "index"],
    "/user" => [User::class, "index"],
    "/user/(:any)" => [User::class, "getUser"],
    "/user/test/(:any)" => [User::class, "getUser"],
    "/login" => [Auth::class, "logInPage", "guest_only", "/portal"],
    "/login/post" => [Auth::class, "credentialLogin", "guest_only", "/login"],
    "/logout" => [Auth::class, "logout", "auth_only", "/login"],
    "/register" => [Auth::class, "signUpPage", "guest_only", "/"],
    "/register/post" => [Auth::class, "register", "guest_only", "/register"],
    "/portal" => [Portal::class, "index"],
    "/portal/contracts" => [Portal::class, "contracts"],
    "/portal/new/contract" => [Contract::class, "new_contract"],
    "/portal/new/contract/post" => [Contract::class, "create" ],
    "/portal/insurance-events" => [Portal::class, "insuranceEvents"],
    "/portal/vehicles" => [Portal::class, "vehicles"],
    "/ares" => [Ares::class, "fetch"]
 ];
