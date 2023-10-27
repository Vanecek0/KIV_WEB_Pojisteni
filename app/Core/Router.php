<?php

namespace App\Core;

use App\Controllers\PageError;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Router
{
    private RouteParser $routeParser;
    private string $actualRoute;
    private array $routes;

    private Request $request;
    private Response $response;

    private $controllerClass;
    private string $action;

    private FilesystemLoader $twigLoader;
    private Environment $twig;

    public function __construct(Request $request, Response $response)
    {
        $this->routeParser = new RouteParser();
        $this->routes = $this->routeParser->getRoutes();
        $this->actualRoute = $this->routeParser->getActualRoute();
        $this->request = $request;
        $this->response = $response;
        [$this->controllerClass, $this->action] = array_key_exists($this->actualRoute, $this->routes) ? $this->routes[$this->actualRoute] : [PageError::class, "pageNotFound"];
        $this->twigLoader = new \Twig\Loader\FilesystemLoader('../app/Views/');
        $this->twig = new \Twig\Environment($this->twigLoader);
    }

    public function resolve() {
        $controller = new $this->controllerClass($this->twig);
        return call_user_func([$controller, $this->action], $this->request, $this->response);
    }

    public function getControllerClass():string {
        return $this->controllerClass;
    }

    public function getAction():string {
        return $this->action;
    }

    public function renderView() {
        echo $this->resolve();
    }
}
