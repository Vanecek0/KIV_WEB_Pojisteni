<?php

namespace App\Core;

class Application
{
    public Router $router;
    private RouteParser $routeParser;
    public Request $request;
    public Response $response;
    public Session $session;
    public FlashMessage $flashMessage;

    public static Application $app;

    public function __construct()
    {
        self::$app = $this;
        $this->session = Session::getInstance();
        $this->flashMessage = new FlashMessage();
        $this->routeParser = new RouteParser();
        $this->request = new Request($this->routeParser);
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run() {
        $this->router->render();
    }
}