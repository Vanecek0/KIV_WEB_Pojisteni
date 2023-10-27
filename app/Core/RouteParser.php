<?php

namespace App\Core;

class RouteParser
{
    private $routes;

    public function __construct()
    {
        $this->routes = require "Routes.php";
    }

    public function getActualRoute():string
    {
        if (!isset($_GET['url'])) {
            return '/';
        }

        $urlBase = $_GET['url'];
        $urlPath = rtrim(parse_url($urlBase, PHP_URL_PATH), '/');
        $urlArray = explode('/', $urlBase);

        $matches = array_filter(
            array_keys($this->routes),
            fn ($url) => stripos($url, $urlPath) !== false
        );
        

        if (in_array('/' . $urlPath, $matches)) {
            return $matches[array_key_first($matches)];
        } else {
            $urlArraySliced = '/' . implode('/', array_slice($urlArray, 0, -1));
            return ($urlArraySliced . '/(:any)');
        }
    }

    public function getRoutes():array {
        return $this->routes;
    }
    
}