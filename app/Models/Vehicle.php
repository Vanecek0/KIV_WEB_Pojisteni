<?php

namespace App\Models;

use App\Core\Database;
use App\Interfaces\IDBmodel;
use JsonSerializable;

class Vehicle implements IDBmodel, JsonSerializable
{
    public const MODEL_OPTIONS = ["KOMFORT", "PLUS", "EXTRA", "MAX"];
    public const PAYMENT_STATE_OPTIONS = ["UNPAID", "WAITING", "DECLINED", "PAID"];

    public int $id;
    public string $brand;
    public string $model;
    public string $type;
    public string $engine_power;
    public string $engine_capacity;
    public string $fuel_type;
    public string $manufacture_year;
    public string $registration_date;
    public string $vin;
    public string $photos;

    private Database $db;
    protected $table = 'vehicles';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data)
    { 
        return null;
    }

    public function update(int $id, array $data)
    {
        return null;
    }

    public function delete(int $id)
    {
        return null;
    }

    public function getAll()
    {
        return null;
    }

    public function getById(int $id)
    {
        return null;
    }

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'brand' => $this->brand,
            'type' => $this->type,
            'engine_power' => $this->engine_power,
            'engine_capacity' => $this->engine_capacity,
            'fuel_type' => $this->fuel_type,
            'manufacture_year' => $this->manufacture_year,
            'registration_date' => $this->registration_date,
            'vin' => $this->vin,
            'photos' => $this->photos,
        ];
    }
}