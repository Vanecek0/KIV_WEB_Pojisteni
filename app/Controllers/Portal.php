<?php
namespace App\Controllers;

use App\Core\Session;
use App\Interfaces\IController;
use App\Models\User as UserModel;
use Twig\Environment;

class Portal implements IController{
    private Environment $twig;
    private UserModel $usermodel;
    private Session $session;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->usermodel = new UserModel();
        $this->session = Session::getInstance();
    }

    public function index() {
        if(!$this->session->get('user')) {
            return $this->twig->render('Login/index.twig');
        }

        return $this->twig->render('Portal/index.twig', [
            "template" => "overview.twig",
            "user" => json_decode($this->session->get('user'))
        ]);
    }

    public function contracts() {
        return $this->twig->render('Portal/index.twig', [
            "template" => "contracts.twig",
        ]);
    }
}