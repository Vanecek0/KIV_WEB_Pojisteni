<?php

namespace App\Core;

use App\Controllers\PageError;

class Router
{

    public function __construct()
    {
        $routes = require "Routes.php";
        $url = $this->urlParser($routes);
        [$controllerClass, $action] = array_key_exists($url, $routes) ? $routes[$url] : [PageError::class, "pageNotFound"];

        $loader = new \Twig\Loader\FilesystemLoader('../app/Views/');
        $twig = new \Twig\Environment($loader);

        $controller = new $controllerClass($twig);
        $response = call_user_func([$controller, $action], new Request($url));
        echo $response;
    }

    public function urlParser(array $routes): string
    {
        if (!isset($_GET['url'])) {
            return '/';
        }

        $urlBase = $_GET['url'];
        $urlPath = rtrim(parse_url($urlBase, PHP_URL_PATH), '/');
        $urlArray = explode('/', $urlBase);

        $matches = array_filter(
            array_keys($routes),
            fn ($url) => stripos($url, $urlPath) !== false
        );

        if (in_array('/' . $urlPath, $matches)) {
            return $matches[array_key_first($matches)];
        } else {
            $urlArraySliced = '/' . implode('/', array_slice($urlArray, 0, -1));
            return ($urlArraySliced . '/(:any)');
        }
    }
}
