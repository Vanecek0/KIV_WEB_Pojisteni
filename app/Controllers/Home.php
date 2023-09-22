<?php
namespace App\Controllers;

use Twig\Environment;

class Home implements \App\Interfaces\IController {

    private Environment $twig;

    public function __construct(Environment $twig) {
        $this->twig = $twig;
    }

    public function index() {
        return $this->twig->render('Home/index.twig', [
            "name" => "Fabian"
        ]);
    
    }

}