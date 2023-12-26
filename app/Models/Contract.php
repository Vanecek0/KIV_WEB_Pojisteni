<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Session;
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
    public string $price;
    public string $payment_state;
    public string $valid_from;
    public string $valid_to;
    public string $notes;

    public Vehicle $vehicle;

    private Database $db;
    protected $table = 'contracts';

    private array $userSession;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->userSession = (array) json_decode(Session::getInstance()->get('user'));
    }

    public function create(array $data)
    {
        $this->db->insert($this->table, $data);
        return true;
    }

    public function update(int $id, array $data, array $condition)
    {
        $tableName = $this->table;
        $result = $this->db->update(Contract::class, $data, $condition, $tableName);

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
        return json_encode($this->db->select(Contract::class, null, $condition, $this->table));
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

    public function getCount()
    {
        return $this->db->query("
    SELECT COUNT(*) as count FROM contracts c
    INNER JOIN vehicles v ON c.vehicle_id = v.id", [])->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getById(int $id)
    {
        return null;
    }

    public function getWithOffsetLimit(int $offset, int $limit, string $sort, string $orderby, string $search = null)
    {
        return $this->db->query("
        SELECT v.*, u.*, c.*
        FROM $this->table c
        INNER JOIN vehicles v ON c.vehicle_id = v.id
        INNER JOIN users u ON c.client_id = u.id
        WHERE 
            c.id LIKE '%$search%' OR
            c.client_id LIKE '%$search%' OR
            c.vehicle_id LIKE '%$search%' OR
            c.type LIKE '%$search%' OR
            c.payment_state LIKE '%$search%' OR
            c.valid_from LIKE '%$search%' OR
            c.valid_to LIKE '%$search%' OR
            c.notes LIKE '%$search%'
        ORDER BY c.$orderby $sort
        LIMIT $limit OFFSET $offset
    ")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getContractConstants()
    {
        return array(
            'TYPE_OPTIONS' => self::TYPE_OPTIONS,
            'PAYMENT_STATE_OPTIONS' => self::PAYMENT_STATE_OPTIONS,
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'vehicle_id' => $this->vehicle_id,
            'type' => $this->type,
            'price' => $this->price,
            'payment_state' => $this->payment_state,
            'valid_from' => $this->valid_from,
            'valid_to' => $this->valid_to,
            'notes' => $this->notes
        ];
    }
}
