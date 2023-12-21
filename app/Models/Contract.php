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

        /*if (!in_array($data['type'], self::TYPE_OPTIONS)) {
            throw new InvalidArgumentException("Invalid type: " . $data['type']);
        }
        if (!in_array($data['payment_state'], self::PAYMENT_STATE_OPTIONS)) {
            throw new InvalidArgumentException("Invalid payment state: " . $data['payment_state']);
        }*/

        $this->db->insert($this->table, [
            'client_id' => '1',
            'vehicle_id' => '2',
            'type' => $data['type'],
            'price' => $data['price'],
            'payment_state' => 'UNPAID',
            'valid_from' => time(),
            'valid_to' => '2023-11-08 14:53:05',
            'notes' => 'OK'
        ]);
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

    public function get(array $condition)
    {
        if ($this->hasAccess($this->userSession, Role::ROLE_ADMIN)) { //Vytvořit access (hasaccess) controller v Core
            if (!empty($condition) && key($condition) !== key(array_keys($condition))) {
                $condition = array_combine(array_map(function($key) { return "$key ="; }, array_keys($condition)), $condition);
            }
            return json_encode($this->db->select(User::class, $condition, $this->table));
        }
        return false;
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
        if ($this->hasAccess($this->userSession, Role::ROLE_ADMIN)) {
            return $this->db->query("SELECT id, client_id, vehicle_id, type, price, payment_state, valid_from, valid_to, notes FROM $this->table
            WHERE 
            id LIKE '%$search%' OR
            client_id LIKE '%$search%' OR
            vehicle_id LIKE '%$search%' OR
            type LIKE '%$search%' OR
            payment_state LIKE '%$search%' OR
            valid_from LIKE '%$search%' OR
            valid_to LIKE '%$search%' OR
            notes LIKE '%$search%' OR
            ORDER BY $orderby $sort
            LIMIT $limit OFFSET $offset", [])->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
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
