<?php

namespace App\Controllers;

use App\Core\FlashMessage;
use App\Core\Request;
use App\Core\Session;
use App\DTO\InsuranceEventFormDTO;
use App\Interfaces\IController;
use App\Models\Contract as ContractModel;
use App\Models\FileUpload as FileUploadModel;
use App\Models\InsuranceEvent as InsuranceEventModel;
use Twig\Environment;

class InsuranceEvent implements IController
{
    private Environment $twig;
    private InsuranceEventModel $insurancemodel;
    private ContractModel $contractmodel;
    private FlashMessage $flashmessage;
    private Session $session;
    private FileUploadModel $imageupload;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->insurancemodel = new InsuranceEventModel();
        $this->contractmodel = new ContractModel();
        $this->session = Session::getInstance();
        $this->flashmessage = new FlashMessage();
        $this->imageupload = new FileUploadModel();
    }

    public function new_event()
    {
        return $this->twig->render('InsuranceEvent/index.twig', [
            "template" => "create.twig",
            "user_contracts" => json_decode($this->contractmodel->get(["client_id" => $this->getUserFromSession()->id])),
            "user" => $this->getUserFromSession(),
        ]);
    }

    public function create(Request $request)
    {
        if (!$request->isPost()) {
            $request->redirect('/portal/insurance-events');
            return false;
        }

        $contract_id = (int)$request->getBody()['contract_id'];
        $accident_datetime = $request->getBody()['accident_datetime'];
        $accident_place = $request->getBody()['accident_place'];
        $accident_description = $request->getBody()['accident_description'];
        $estimated_damage_amount = (int)$request->getBody()['estimated_damage_amount'];
        $culprit_firstname = $request->getBody()['culprit_firstname'];
        $culprit_lastname = $request->getBody()['culprit_lastname'];
        $culprit_phone = $request->getBody()['culprit_phone'];
        $culprit_email = $request->getBody()['culprit_email'];
        $culprit_city = $request->getBody()['culprit_city'];
        $culprit_street = $request->getBody()['culprit_street'];
        $culprit_psc = $request->getBody()['culprit_psc'];
        $culprit_spz = $request->getBody()['culprit_spz'];
        $culprit_vehicle = $request->getBody()['culprit_vehicle'];
        $culprit_insurance = $request->getBody()['culprit_insurance'];

        $insuranceFormDTO = new InsuranceEventFormDTO(
            null,
            $contract_id,
            $accident_datetime,
            $accident_place,
            $accident_description,
            $estimated_damage_amount,
            $culprit_firstname,
            $culprit_lastname,
            $culprit_phone,
            $culprit_email,
            $culprit_city,
            $culprit_street,
            $culprit_psc,
            $culprit_spz,
            $culprit_vehicle,
            $culprit_insurance
        );

        return $this->handleCreate($insuranceFormDTO);
    }

    private function handleCreate(InsuranceEventFormDTO $insuranceFormDTO)
    {
        $uploadedFile = $_FILES['images'];

        if (!in_array(UPLOAD_ERR_OK, $uploadedFile['error']) && !in_array(UPLOAD_ERR_NO_FILE, $uploadedFile['error'])) {
            $this->flashmessage->setFlashMessage("insurance_error", "Soubor se nepodařilo nahrát.");
            echo $this->flashmessage->getMessagesArray();
            return false;
        }

        if (!in_array(UPLOAD_ERR_NO_FILE, $uploadedFile['error']) || (!in_array(0, $uploadedFile['size']) && !in_array(UPLOAD_ERR_OK, $uploadedFile['error']))) {
            foreach ($uploadedFile['tmp_name'] as $key => $tmp_name) {
                $fileType = mime_content_type($tmp_name);
                $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];

                if (!in_array($fileType, $allowedTypes)) {
                    $this->flashmessage->setFlashMessage("insurance_error", "Byl nahrán soubor nesprávného typu.");
                    echo $this->flashmessage->getMessagesArray();
                    return false;
                }
            }
        }


        if ($insuranceFormDTO) {
            $inserted_insurance_event = $this->insurancemodel->create($insuranceFormDTO->toArray());
            $insuranceFormDTO->id = $inserted_insurance_event;
            $this->imageupload->uploadImages($this->insurancemodel, $insuranceFormDTO, 'images');
        }

        $this->flashmessage->setFlashMessage("insurance_message", "Nová pojistná událost byla úspěšně vytvořena.");
        return $this->flashmessage->getMessagesArray();
    }

    private function getUserFromSession()
    {
        return $this->session->get('user') ? json_decode($this->session->get('user')) : null;
    }
}
