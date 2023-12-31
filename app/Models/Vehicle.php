<?php

namespace App\Models;

use App\Core\Database;
use App\Interfaces\IDBmodel;
use JsonSerializable;
use PDO;

class Vehicle implements IDBmodel, JsonSerializable
{

    public int $id;
    public int $user_id;
    public string $brand;
    public string $model;
    public string $engine_power;
    public string $engine_capacity;
    public string $fuel_type;
    public string $manufacture_year;
    public string $registration_date;
    public string $vin;
    public string $spz;
    public ?string $images;

    public User $user;

    private Database $db;
    public $table = 'vehicles';

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function create(array $data)
    {
        return $this->db->insert($this->table, $data);;
    }

    public function update(int $id, array $data, array $condition)
    {
        $tableName = $this->table;
        $result = $this->db->update(Vehicle::class, $data, $condition, $tableName);

        if ($result == null) {
            return null;
        }

        return $result;
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
        $vehicleData = $this->db->query("
    SELECT v.*, u.* FROM vehicles v
    INNER JOIN users u ON v.user_id = u.id", [])->fetchAll(PDO::FETCH_ASSOC);


        $vehicles = [];
        foreach ($vehicleData as $data) {
            $vehicle = new Vehicle();
            $vehicle->hydrate($data);

            $user = new User();
            $user->hydrate($data);

            $vehicle->user = $user;
            $vehicles[] = $vehicle;
        }

        if (!$vehicles) {
            return null;
        }
        return $vehicles;
    }

    public function getCount()
    {
        return $this->db->query("
    SELECT COUNT(*) as count FROM vehicles v
    INNER JOIN users u ON v.user_id = u.id", [])->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getById(int $id)
    {
        return null;
    }

    public function get(array $condition)
    {
        if (!empty($condition) && key($condition) !== key(array_keys($condition))) {
            $condition = array_combine(array_map(function ($key) {
                return $key;
            }, array_keys($condition)), $condition);
        }
        return json_encode($this->db->select(Vehicle::class, null, $condition, $this->table));
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'brand' => $this->brand,
            'model' => $this->model,
            'engine_power' => $this->engine_power,
            'engine_capacity' => $this->engine_capacity,
            'fuel_type' => $this->fuel_type,
            'manufacture_year' => $this->manufacture_year,
            'registration_date' => $this->registration_date,
            'vin' => $this->vin,
            'spz' => $this->spz,
            'images' => $this->images,
        ];
    }
}
