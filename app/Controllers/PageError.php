<?php
namespace App\Controllers;

use App\Core\Application;
use App\Interfaces\IController;
use Twig\Environment;

class PageError implements IController {

    private Environment $twig;

    public function __construct( Environment $twig) {
        $this->twig = $twig;
    }

    public function index () {
        return $this->pageNotFound();
    }

    public function pageNotFound () {
        Application::$app->response->setStatus(404);
        return $this->twig->render('PageError/index.twig', [
            "errorTitle" => "404 Page not found"
        ]);
    }

}