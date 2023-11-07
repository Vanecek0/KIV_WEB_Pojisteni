<?php

namespace App\Core;

class Request
{

    private array $urlParams = [];
    private RouteParser $routeParser;
    private $actualRoute;

    public function __construct(RouteParser $routeParser)
    {
        $this->urlParams = explode('/', $_GET['url'] ?? '/');
        $this->routeParser = $routeParser;
        $this->actualRoute = $this->routeParser->getActualRoute();
    }

    public function redirect($url, $statusCode = 303)
    {
        header('Location: ' . $url, true, $statusCode);
        die();
    }

    public function get()
    {
        return array_values(array_diff($this->urlParams, $this->getPath()));
    }

    public function getPath()
    {
        return array_filter(array_slice(explode('/', $this->actualRoute), 0, -1));
    }

    public function getMethod()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function getBody()
    {
        $body = [];
        if ($this->getMethod() === 'get') {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->getMethod() === 'post') {
            foreach ($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }

    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    public function isGet()
    {
        return $this->getMethod() === 'get';
    }
}
