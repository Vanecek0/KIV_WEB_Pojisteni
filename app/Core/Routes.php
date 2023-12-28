<?php
namespace App\Core;

use App\API\Ares;
use App\API\Contracts;
use App\API\InsuranceEvents;
use App\API\Users;
use App\API\Roles;
use App\Controllers\Admin;
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
    "/portal" => [Portal::class, "index", "auth_only", "/login"],
    "/portal/contracts" => [Portal::class, "contracts", "auth_only", "/login"],
    "/portal/new/contract" => [Contract::class, "new_contract", "auth_only", "/login"],
    "/portal/new/contract/post" => [Contract::class, "create", "auth_only", "/login"],
    "/portal/insurance-events" => [Portal::class, "insuranceEvents", "auth_only", "/login"],
    "/portal/vehicles" => [Portal::class, "vehicles", "auth_only", "/login"],
    "/admin" => [Admin::class, "index", "auth_only", "/login"],
    "/admin/clients" => [Admin::class, "clients", "auth_only", "/login"],
    "/admin/contracts" => [Admin::class, "contracts", "auth_only", "/login"],
    "/admin/insurance-events" => [Admin::class, "insuranceEvents", "auth_only", "/login"],
    "/ares" => [Ares::class, "fetch"],
    "/users" => [Users::class, "fetchAll"],
    "/users/get" => [Users::class, "get"],
    "/users/delete" => [Users::class, "delete"],
    "/users/update" => [Users::class, "update"],
    "/users/create" => [Users::class, "create"],
    "/insurances" => [InsuranceEvents::class, "fetchAll"],
    "/insurances/get" => [InsuranceEvents::class, "get"],
    "/insurances/delete" => [InsuranceEvents::class, "delete"],
    "/insurances/update" => [InsuranceEvents::class, "update"],
    "/insurances/create" => [InsuranceEvents::class, "create"],
    "/insurances-constants" => [InsuranceEvents::class, "getAllContstants"],

    "/insurance-contracts" => [Contracts::class, "fetchAll"],
    "/insurance-contracts/get" => [Contracts::class, "get"],
    "/insurance-contracts/delete" => [Contracts::class, "delete"],
    "/insurance-contracts/update" => [Contracts::class, "update"],
    "/insurance-contracts/create" => [Contracts::class, "create"],
    "/contracts-constants" => [Contracts::class, "getAllContstants"],
    "/roles" => [Roles::class, "getAll"],
    "/roles/get" => [Roles::class, "getRoleByValue"],
 ];