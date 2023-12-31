<?php

namespace App\Models;

use App\Core\Database;
use App\Interfaces\IDBmodel;
use JsonSerializable;
use PDO;

class InsuranceEvent implements IDBmodel, JsonSerializable
{

    public const REPORT_STATE = ["PROBÍHÁ", "ZAMÍTNUTO", "UZAVŘENO"];

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
    public $table = 'reports';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data)
    {
        $this->db->insert($this->table, $data);
        return true;
    }

    public function update(int $id, array $data, array $condition)
    {
        $tableName = $this->table;
        $result = $this->db->update(InsuranceEvent::class, $data, $condition, $tableName);

        if ($result == null) {
            return null;
        }

        return $result;
    }

    public function delete(int $id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function get(array $condition)
    {
        if (!empty($condition) && key($condition) !== key(array_keys($condition))) {
            $condition = array_combine(array_map(function ($key) {
                return $key;
            }, array_keys($condition)), $condition);
        }
        return json_encode($this->db->select(InsuranceEvent::class, null, $condition, $this->table));
    }


    public function getAll()
    {

        $insurancesData = $this->db->query("
        SELECT c.*, r.* FROM $this->table r
        INNER JOIN contracts c ON r.contract_id = c.id", [])->fetchAll(PDO::FETCH_ASSOC);

        $insurances = [];
        foreach ($insurancesData as $data) {

            $insurance = new InsuranceEvent();
            $insurance->hydrate($data);

            $contract = new Contract();
            $contract->hydrate($data);

            $insurance->contract = $contract;
            $insurances[] = $insurance;
        }

        if (!$insurances) {
            return null;
        }
        return $insurances;
    }

    public function getWithOffsetLimit(int $offset, int $limit, string $sort, string $orderby, string $search = null)
    {
        return $this->db->query("
        SELECT c.*, r.*
        FROM $this->table r
        INNER JOIN contracts c ON r.contract_id = c.id
        WHERE 
            r.id LIKE '%$search%' OR
            r.contract_id LIKE '%$search%' OR
            r.accident_datetime LIKE '%$search%' OR
            r.accident_place LIKE '%$search%' OR
            r.accident_description LIKE '%$search%' OR
            r.estimated_damage_amount LIKE '%$search%' OR
            r.culprit_firstname LIKE '%$search%' OR
            r.culprit_lastname LIKE '%$search%' OR
            r.culprit_phone LIKE '%$search%' OR
            r.report_state LIKE '%$search%' OR
            r.closed_datetime LIKE '%$search%' OR
            r.notes LIKE '%$search%'
        ORDER BY r.$orderby $sort
        LIMIT $limit OFFSET $offset
    ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCount()
    {
        return $this->db->query("
    SELECT COUNT(*) as count FROM $this->table r
    INNER JOIN contracts c ON r.contract_id = c.id", [])->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getById(int $id)
    {
        return null;
    }

    public static function getInsuranceConstants()
    {
        return array(
            'REPORT_STATE_OPTIONS' => self::REPORT_STATE,
        );
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