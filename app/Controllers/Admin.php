<?php

namespace App\Controllers;

use App\Core\Session;
use App\Interfaces\IController;
use App\Models\Contract;
use App\Models\InsuranceEvent;
use App\Models\User as UserModel;
use App\Models\Vehicle;
use Twig\Environment;


class Admin implements IController
{
    private Environment $twig;
    private UserModel $usermodel;
    private Session $session;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->usermodel = new UserModel();
        $this->session = Session::getInstance();
    }

    public function index()
    {   
        
        return $this->renderAdminIndex([
            "template" => "overview.twig",
        ]);
    }

    public function clients()
    {
        return $this->renderAdminIndex([
            "template" => "clients.twig",
        ]);
    }

    public function contracts()
    {
        return $this->renderAdminIndex([
            "template" => "contracts.twig",
        ]);
    }

    public function insuranceEvents()
    {
        return $this->renderAdminIndex([
            "template" => "insurance-events.twig",
        ]);
    }

    private function renderAdminIndex(array $data)
    {
        $user = $this->getUserFromSession();

        return $this->twig->render('Admin/index.twig', array_merge($data, ["user" => $user]));
    }


    private function getUserFromSession()
    {
        return $this->session->get('user') ? json_decode($this->session->get('user')) : null;
    }
}