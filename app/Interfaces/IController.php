<?php
namespace App\Interfaces;

use Twig\Environment;

interface IController {

    public function __construct(Environment $twig);
}