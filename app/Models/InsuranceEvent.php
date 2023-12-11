<?php

namespace App\Models;

use App\Core\Database;
use App\Interfaces\IDBmodel;
use InvalidArgumentException;
use JsonSerializable;
use PDO;

class InsuranceEvent implements IDBmodel, JsonSerializable
{

    public const REPORT_STATE = ["IN_PROGRESS", "REJECTED", "SUCCESSFULLY_CLOSED"];

    public int $id;
    public int $contract_id;
    public string $accident_datetime;
    public string $accident_place;
    public string $accident_description;
    public string $estimated_damage_amount;
    public string $culprit_firstname;
    public string $culprit_lastname;
    public string $culprit_phone;
    public string $report_state;
    public string $closed_datetime;
    public string $files;
    public string $notes;

    public Contract $contract;

    private Database $db;
    protected $table = 'reports';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data)
    {

        return true;
    }

    public function update(int $id, array $data)
    {
        return null;
    }

    public function delete(int $id)
    {
        return null;
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getAll()
    {

        $insuranceEventData = $this->db->query("
    SELECT r.*, c.* FROM reports r
    INNER JOIN contracts c ON r.contract_id = c.id", [])->fetchAll(PDO::FETCH_ASSOC);

        $insuranceEvents = [];
        foreach ($insuranceEventData as $data) {
            $insuranceEvent = new InsuranceEvent();
            $insuranceEvent->hydrate($data);

            $contract = new Contract();
            $contract->hydrate($data);

            $insuranceEvent->contract = $contract;
            $insuranceEvents[] = $insuranceEvent;
        }

        if (!$insuranceEvents) {
            return null;
        }
        return $insuranceEvents;
    }

    public function getById(int $id)
    {
        return null;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'contract_id' => $this->contract_id,
            'accident_datetime' => $this->accident_datetime,
            'accident_place' => $this->accident_place,
            'accident_description' => $this->accident_description,
            'estimated_damage_amount' => $this->estimated_damage_amount,
            'culprit_firstname' => $this->culprit_firstname,
            'culprit_lastname' => $this->culprit_lastname,
            'culprit_phone' => $this->culprit_phone,
            'report_state' => $this->report_state,
            'closed_datetime' => $this->closed_datetime,
            'files' => $this->culprit_firstname,
            'notes' => $this->notes,

        ];
    }
}
