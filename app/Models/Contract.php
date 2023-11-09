<?php

namespace App\Models;

use App\Core\Database;
use App\Interfaces\IDBmodel;
use InvalidArgumentException;
use JsonSerializable;
use PDO;

class Contract implements IDBmodel, JsonSerializable
{

    public const TYPE_OPTIONS = ["KOMFORT", "PLUS", "EXTRA", "MAX"];
    public const PAYMENT_STATE_OPTIONS = ["UNPAID", "WAITING", "DECLINED", "PAID"];

    public int $id;
    public int $client_id;
    public int $vehicle_id;
    public string $type;
    public string $payment_state;
    public string $valid_from;
    public string $valid_to;
    public string $notes;

    public Vehicle $vehicle;

    private Database $db;
    protected $table = 'contracts';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data)
    {

        if (!in_array($data['type'], self::TYPE_OPTIONS)) {
            throw new InvalidArgumentException("Invalid type: " . $data['type']);
        }
        if (!in_array($data['payment_state'], self::PAYMENT_STATE_OPTIONS)) {
            throw new InvalidArgumentException("Invalid payment state: " . $data['payment_state']);
        }

        $this->db->insert($this->table, $data);
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
        /*$contracts = $this->db->query("
        SELECT v.*, c.* FROM contracts c
        INNER JOIN vehicles v ON c.vehicle_id = v.id", [])->fetchAll(PDO::FETCH_FUNC, function (
            $v_id,
            $brand,
            $model,
            $v_type,
            $engine_power,
            $engine_capacity,
            $fuel_type,
            $manufacture_year,
            $registration_date,
            $vin,
            $photos,
            $c_id,
            $client_id,
            $vehicle_id,
            $c_type,
            $payment_state,
            $valid_from,
            $valid_to,
            $notes
        ) {

            $contract = new Contract();
            $contract->id = $c_id;
            $contract->client_id = $client_id;
            $contract->vehicle_id = $vehicle_id;
            $contract->type = $c_type;
            $contract->payment_state = $payment_state;
            $contract->valid_from = $valid_from;
            $contract->valid_to = $valid_to;
            $contract->notes = $notes;

            $contract->vehicle = new Vehicle();
            $contract->vehicle->v_id = $v_id;
            $contract->vehicle->brand = $brand;
            $contract->vehicle->model = $model;
            $contract->vehicle->v_type = $v_type;
            $contract->vehicle->engine_power = $engine_power;
            $contract->vehicle->engine_capacity = $engine_capacity;
            $contract->vehicle->fuel_type = $fuel_type;
            $contract->vehicle->manufacture_year = $manufacture_year;
            $contract->vehicle->registration_date = $registration_date;
            $contract->vehicle->vin = $vin;
            $contract->vehicle->photos = $photos;

            return $contract;
        });*/

        $contractsData = $this->db->query("
        SELECT v.*, c.* FROM contracts c
        INNER JOIN vehicles v ON c.vehicle_id = v.id", [])->fetchAll(PDO::FETCH_ASSOC);

        $contracts = [];
        foreach ($contractsData as $data) {
            $contract = new Contract();
            $contract->hydrate($data);

            $vehicle = new Vehicle();
            $vehicle->hydrate($data);

            $contract->vehicle = $vehicle;
            $contracts[] = $contract;
        }

        if (!$contracts) {
            return null;
        }
        return $contracts;
    }

    public function getById(int $id)
    {
        return null;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'vehicle_id' => $this->vehicle_id,
            'type' => $this->type,
            'payment_state' => $this->payment_state,
            'valid_from' => $this->valid_from,
            'valid_to' => $this->valid_to,
            'notes' => $this->notes
        ];
    }
}