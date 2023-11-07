<?php
namespace App\Controllers;

use App\Core\Session;
use Twig\Environment;

class User implements \App\Interfaces\IController {

    private Environment $twig;
    private array $user;

    public function __construct(Environment $twig) {
        $this->twig = $twig;
        $this->user = (array) json_decode(Session::getInstance()->get('user'));
    }

    public function index() {
        return $this->twig->render('Home/index.twig', [
            "user" => $this->user
        ]);
    }

    public function getUser() {
        return $this->twig->render('Home/index.twig', [
            "user" => $this->user
        ]);
    }

}