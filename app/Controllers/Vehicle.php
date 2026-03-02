<?php

namespace App\Controllers;

use App\Core\FlashMessage;
use App\Interfaces\IController;
use App\Models\Vehicle as VehicleModel;
use Twig\Environment;

class Vehicle implements IController
{
    private Environment $twig;
    private VehicleModel $vehicleModel;
    private string $cars;
    private FlashMessage $flashmessage;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->vehicleModel = new VehicleModel();
        $this->cars = file_get_contents('../app/Lists/Cars.json');
        $this->flashmessage = new FlashMessage();
    }
}
