<?php

namespace App\Controllers;

use App\Core\Request;
use App\DTO\ContractFormDTO;
use App\Interfaces\IController;
use App\Models\Contract as ContractModel;
use Twig\Environment;

class Contract implements IController
{
    private Environment $twig;
    private ContractModel $contractmodel;
    private string $cars;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->cars = file_get_contents('../app/Lists/Cars.json'); 
        
    }

    public function new_contract()
    {
        return $this->twig->render('Contract/index.twig', [
            "template" => "create.twig",
            "cars" => json_decode($this->cars)
        ]);
    }

    public function create(Request $request) {
        if (!$request->isPost()) {
            $request->redirect('/portal/new/contract');
            return false;
        }
        $vehicle = $request->getBody()['vehicle'];
        $spz = $request->getBody()['spz'];
        $insurer = $request->getBody()['insurer'];
        $ico = $request->getBody()['ico'];
        $dic = $request->getBody()['dic'];
        $firstname = $request->getBody()['firstname'];
        $lastname = $request->getBody()['lastname'];
        $birth = $request->getBody()['birth'];
        $birth_number = $request->getBody()['birth_number'];
        $phone_number = $request->getBody()['phone_number'];
        $email = $request->getBody()['email'];
        $city = $request->getBody()['city'];
        $street = $request->getBody()['street'];
        $psc = $request->getBody()['psc'];

        $contractFormDTO = new ContractFormDTO(
            $vehicle, 
            $spz, 
            $insurer, 
            $ico, 
            $dic, 
            $firstname, 
            $lastname,
            $birth,
            $birth_number,
            $phone_number,
            $email, 
            $city,
            $street,
            $psc
        );

        if (!$this->handleCreate($contractFormDTO)) {
            return false;
        }

        return $this->handleCreate($contractFormDTO);
    }

    private function handleCreate(ContractFormDTO $contractFormDTO) {
        $insertContract = $this->contractmodel->create($contractFormDTO->toArray());
    }

    public function delete()
    {
        var_dump("test");
    }
}
