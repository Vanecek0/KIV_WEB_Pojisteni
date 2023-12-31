<?php

namespace App\Controllers;

use App\Core\FlashMessage;
use App\Core\Request;
use App\Core\Session;
use App\DTO\ContractFormDTO;
use App\DTO\VehicleFormDTO;
use App\Interfaces\IController;
use App\Models\Contract as ContractModel;
use App\Models\FileUpload as FileUploadModel;
use App\Models\Vehicle as VehicleModel;
use Twig\Environment;

class Contract implements IController
{
    private Environment $twig;
    private ContractModel $contractmodel;
    private string $cars;
    private FlashMessage $flashmessage;
    private Session $session;
    private VehicleModel $vehiclemodel;
    private FileUploadModel $imageupload;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->contractmodel = new ContractModel();
        $this->cars = file_get_contents('../app/Lists/Cars.json');
        $this->flashmessage = new FlashMessage();
        $this->session = Session::getInstance();
        $this->vehiclemodel = new VehicleModel();
        $this->imageupload = new FileUploadModel();
    }

    public function new_contract()
    {
        return $this->twig->render('Contract/index.twig', [
            "template" => "create.twig",
            "user" => $this->getUserFromSession(),
            "user_vehicles" => json_decode($this->vehiclemodel->get(["user_id" => $this->getUserFromSession()->id])),
            "cars" => array_reduce(json_decode($this->cars, true), function ($acc, $entry) {
                $make = $entry["make"];
                unset($entry["make"]);
                $acc[$make]["make"] = $make;
                $acc[$make]["models"][] = $entry;
                return $acc;
            }, [])
        ]);
    }

    public function create(Request $request)
    {
        if (!$request->isPost()) {
            $request->redirect('/portal/new/contract');
            return false;
        }

        $new_vehicle = json_decode(html_entity_decode($request->getBody()['car_model']));
        $vehicleFormDTO = null;

        if ($new_vehicle) {
            $user_id = (int)$request->getBody()['client_id'];
            $brand = $new_vehicle->make;
            $model = $new_vehicle->vehicle[0]->model;
            $engine_power = $new_vehicle->vehicle[0]->eng_power;
            $engine_capacity = $new_vehicle->vehicle[0]->eng_capacity;
            $fuel_type = $new_vehicle->vehicle[0]->fueltype;
            $manufacture_year = $new_vehicle->vehicle[0]->year;
            $registration_date = $request->getBody()['registration_date'];
            $vin = $request->getBody()['vin'];
            $spz = $request->getBody()['spz'];

            $vehicleFormDTO = new VehicleFormDTO(
                null,
                $user_id,
                $brand,
                $model,
                $engine_power,
                $engine_capacity,
                $fuel_type,
                $manufacture_year,
                $registration_date,
                $vin,
                $spz
            );
        }

        $client_id = (int)$request->getBody()['client_id'];
        $vehicle_id = (int)$request->getBody()['car_select'];
        $type = json_decode(html_entity_decode($request->getBody()['type_price']))->type;
        $price = json_decode(html_entity_decode($request->getBody()['type_price']))->price;
        $valid_from = $request->getBody()['valid_from'];
        $valid_to = date("Y-m-d", strtotime($valid_from . " +1 year"));
        $notes = $request->getBody()['notes'];

        $contractFormDTO = new ContractFormDTO(
            $client_id,
            $vehicle_id,
            $type,
            $price,
            $valid_from,
            $valid_to,
            $notes
        );

        return $this->handleCreate($contractFormDTO, $vehicleFormDTO);
    }

    private function handleCreate(ContractFormDTO $contractFormDTO, ?VehicleFormDTO $vehicleFormDTO)
    {
        $uploadedFile = $_FILES['images'];

        if (!in_array(UPLOAD_ERR_OK, $uploadedFile['error']) && $uploadedFile['error'] !== UPLOAD_ERR_NO_FILE) {
            $this->flashmessage->setFlashMessage("file_upload", "Soubor se nepodařilo nahrát.");
            echo $this->flashmessage->getMessagesArray();
            return false;
        }

        if ($uploadedFile['error'] != UPLOAD_ERR_NO_FILE || (!in_array(0, $uploadedFile['size']) && !in_array(UPLOAD_ERR_OK, $uploadedFile['error']))) {
            foreach ($uploadedFile['tmp_name'] as $key => $tmp_name) {
                $fileType = mime_content_type($tmp_name);
                $allowedTypes = ['image/jpg', 'image/jpeg', 'image/png'];

                if (!in_array($fileType, $allowedTypes)) {
                    $this->flashmessage->setFlashMessage("file_upload", "Byl nahrán soubor nesprávného typu.");
                    echo $this->flashmessage->getMessagesArray();
                    return false;
                }
            }
        }

        if ($vehicleFormDTO) {
            $inserted_vehicle = $this->vehiclemodel->create($vehicleFormDTO->toArray());
            $vehicleFormDTO->id = $inserted_vehicle;
            $contractFormDTO->vehicle_id = $inserted_vehicle;
            $this->imageupload->uploadImages($this->vehiclemodel, $vehicleFormDTO, 'images');
        }

        return $this->contractmodel->create($contractFormDTO->toArray());
    }

    private function getUserFromSession()
    {
        return $this->session->get('user') ? json_decode($this->session->get('user')) : null;
    }
}
