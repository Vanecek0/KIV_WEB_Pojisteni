<?php
namespace App\Core;

use App\Controllers\PageError;

class Router {

    public function __construct() {

        $url = $this->parseUrl();
        $routes = require "Routes.php";
        [$controllerClass, $action] = array_key_exists($url, $routes) ? $routes[$url] : [PageError::class, "pageNotFound"];

        $loader = new \Twig\Loader\FilesystemLoader('../app/Views/');
        $twig = new \Twig\Environment($loader);

        $controller = new $controllerClass($twig);
        $response = call_user_func([$controller, $action]);
        echo $response;
    }

    public function parseUrl():string {
        if (isset($_GET['url'])) {
            return '/' . trim($_GET["url"], '/');
        }
        return '/';
    }
}