<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\User as UserModel;
use Twig\Environment;

class User implements \App\Interfaces\IController {

    private Environment $twig;
    private Database $db;
    private UserModel $user;

    public function __construct(Environment $twig) {
        $this->db = Database::getInstance();
        $this->twig = $twig;
        $this->user = new UserModel();
    }

    public function index() {

        return $this->twig->render('Home/index.twig', [
            "name" => "Fabian"
        ]);
    }

    public function getUser($request) {
        $username = $this->user->getUserByUsername($request->get()[0])[0]->username;

        return $this->twig->render('Home/index.twig', [
            "name" => $username
        ]);
    }

}