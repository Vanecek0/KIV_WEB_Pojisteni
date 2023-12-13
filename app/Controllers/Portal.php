<?php

namespace App\Controllers;

use App\Core\Session;
use App\Interfaces\IController;
use App\Models\Contract;
use App\Models\InsuranceEvent;
use App\Models\User as UserModel;
use App\Models\Vehicle;
use Twig\Environment;


class Portal implements IController
{
    private Environment $twig;
    private Contract $contract;
    private InsuranceEvent $insuranceEvent;
    private Vehicle $vehicle;
    private UserModel $usermodel;
    private Session $session;
    private string $cars;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->contract = new Contract();
        $this->insuranceEvent = new InsuranceEvent();
        $this->vehicle = new Vehicle();
        $this->usermodel = new UserModel();
        $this->session = Session::getInstance();
        $this->cars = file_get_contents('../app/Lists/Cars.json');
    }

    public function index()
    {
        $user = $this->getUserFromSession();
        
        return $this->renderPortalIndex([
            "template" => "overview.twig",
            "user" => $user,
            "vehicles_number" => $this->vehicle->getCount(),
            "contracts_number" => $this->contract->getCount()
        ]);
    }

    public function contracts()
    {
        return $this->renderPortalIndex([
            "template" => "contracts.twig",
            "contracts" => $this->contract->getAll()
        ]);
    }

    public function insuranceEvents()
    {
        return $this->renderPortalIndex([
            "template" => "insuranceEvents.twig",
            "insuranceEvents" => $this->insuranceEvent->getAll()
        ]);
    }

    public function vehicles()
    {
        return $this->renderPortalIndex([
            "template" => "vehicles.twig",
            "vehicles" => $this->vehicle->getAll()
        ]);
    }

    private function renderPortalIndex(array $data)
    {
        $user = $this->getUserFromSession();

        return $this->twig->render('Portal/index.twig', array_merge($data, ["user" => $user]));
    }

    private function getUserFromSession()
    {
        return $this->session->get('user') ? json_decode($this->session->get('user')) : null;
    }
}
