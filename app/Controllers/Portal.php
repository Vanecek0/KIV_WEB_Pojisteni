<?php
namespace App\Controllers;

use App\Core\Session;
use App\Interfaces\IController;
use App\Models\Contract;
use App\Models\User as UserModel;
use Twig\Environment;


class Portal implements IController{
    private Environment $twig;
    private Contract $contract;
    private UserModel $usermodel;
    private Session $session;
    private string $cars;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->contract = new Contract();
        $this->usermodel = new UserModel();
        $this->session = Session::getInstance();
        $this->cars = file_get_contents('../app/Lists/Cars.json'); 
    }

    public function index() {
        if(!$this->session->get('user')) {
            return $this->twig->render('Login/index.twig');
        }

        return $this->twig->render('Portal/index.twig', [
            "template" => "overview.twig",
            "user" => json_decode($this->session->get('user')),
            "cars" => json_decode($this->cars)
        ]);
    }

    public function contracts() {
        return $this->twig->render('Portal/index.twig', [
            "template" => "contracts.twig",
            "contracts" => $this->contract->getAll()
        ]);
    }
}