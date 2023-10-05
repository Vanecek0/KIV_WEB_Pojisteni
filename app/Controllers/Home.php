<?php
namespace App\Controllers;

use App\Core\Database;
use App\Models\User;
use Twig\Environment;

class Home implements \App\Interfaces\IController {

    private Environment $twig;
    private Database $db;

    public function __construct(Environment $twig) {
        $this->db = Database::getInstance();
        $this->twig = $twig;
    }

    public function index($request) {
        $userModel = new User();
        echo($request->get());
        echo($userModel->getUserById(1)[0]->username);

        return $this->twig->render('Home/index.twig', [
            "name" => "Fabian"
        ]);
    
    }

}