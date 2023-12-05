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