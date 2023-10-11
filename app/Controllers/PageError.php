<?php
namespace App\Controllers;

use Twig\Environment;

class PageError implements \App\Interfaces\IController {

    private Environment $twig;

    public function __construct( Environment $twig) {
        $this->twig = $twig;
    }

    public function index () {
        return $this->pageNotFound();
    }

    public function pageNotFound () {
        return $this->twig->render('PageError/404.twig', [
            "errorTitle" => "404 Page not found"
        ]);
    }

}