<?php

namespace App\Controllers;

use App\Core\Session;
use App\Models\Role;
use App\Models\User as UserModel;
use Twig\Environment;

class User implements \App\Interfaces\IController
{

    private Environment $twig;
    private array $userSession;
    private UserModel $user;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->userSession = (array) json_decode(Session::getInstance()->get('user'));
    }

    public function index()
    {
        return $this->twig->render('Home/index.twig', [
            "user" => $this->userSession
        ]);
    }

    public function getUser()
    {
        return $this->twig->render('Home/index.twig', [
            "user" => $this->userSession
        ]);
    }
}
