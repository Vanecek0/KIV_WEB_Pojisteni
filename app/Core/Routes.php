<?php
namespace App\Core;

use App\Controllers\Home;

return [ 
    "/" => [Home::class, "index"],
    "/home" => [Home::class, "index"],

 ];
