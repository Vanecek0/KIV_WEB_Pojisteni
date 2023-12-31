<?php

namespace App\Controllers;

use App\Core\FlashMessage;
use App\Core\Request;
use App\DTO\ContractFormDTO;
use App\Interfaces\IController;
use App\Models\Contract as ContractModel;
use App\Models\InsuranceEvent as InsuranceEventModel;
use Twig\Environment;

class InsuranceEvent implements IController
{
    private Environment $twig;
    private InsuranceEventModel $insuranceModel;
    private string $cars;
    private FlashMessage $flashmessage;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->insuranceModel = new InsuranceEventModel();
        $this->cars = file_get_contents('../app/Lists/Cars.json');
        $this->flashmessage = new FlashMessage();
    }

    /*public function new_contract()
    {
        return $this->twig->render('Contract/index.twig', [
            "template" => "create.twig",
            "cars" => json_decode($this->cars)
        ]);
    }

    public function create(Request $request)
    {
        if (!$request->isPost()) {
            $request->redirect('/portal/new/contract');
            return false;
        }
        $expectedKeys = [
            'vehicle', 'spz', 'vin', 'insurer', 'ico', 'dic', 'firstname', 'lastname',
            'birth', 'birth_number', 'phone_number', 'email', 'city', 'street', 'psc', 'car_photos', 'type'
        ];
        $formData = $request->getBody();
        $contractFormDTO = new ContractFormDTO(
            ...array_map(fn ($key) => $formData[$key] ?? '', $expectedKeys)
        );

        return $this->handleCreate($contractFormDTO);
    }

    private function handleCreate(ContractFormDTO $contractFormDTO)
    {
        $uploadedFile = $_FILES['car_photos'];
        var_dump($contractFormDTO);

        if ($uploadedFile['error'] !== UPLOAD_ERR_OK) {
            $this->flashmessage->setFlashMessage("file_upload", "Soubor se nepodařilo nahrát.");
            echo $this->flashmessage->getMessagesArray();
            return false;
        }

        $fileType = mime_content_type($uploadedFile['tmp_name']);
        $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];

        if (!in_array($fileType, $allowedTypes)) {
            $this->flashmessage->setFlashMessage("file_upload", "Byl nahrán soubor nesprávného typu.");
            echo $this->flashmessage->getMessagesArray();
            return false;
        }

        //return $this->contractmodel->create($contractFormDTO->toArray());
    }


    public function delete()
    {
        var_dump("test");
    }*/
}
