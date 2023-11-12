<?php

namespace App\Controllers;

use App\Core\Request;
use App\Interfaces\IController;
use Twig\Environment;

class Contract implements IController
{
    private Environment $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function create()
    {
        return $this->twig->render('Contract/index.twig', [
            "template" => "create.twig"
        ]);
    }

    public function delete()
    {
        var_dump("test");
    }
}
