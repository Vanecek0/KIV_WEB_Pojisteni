<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Session;
use App\Interfaces\IDBmodel;
use JsonSerializable;
use PDO;

class User implements IDBmodel, JsonSerializable
{

    public int $id;
    public string $firstname;
    public string $lastname;
    public string $phone;
    public string $email;
    public string $birth;
    public string $birth_number;
    public string $city;
    public string $street;
    public string $psc;
    public string $username;
    public string $password;
    public string $role;

    public User $user;
    public Session $session;

    private Database $db;
    protected $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->session = Session::getInstance();
    }

    public function create(array $data)
    {

        $existingUser = $this->getByUsername($data['username']);

        if ($existingUser) {
            return false;
        }
        $this->db->insert($this->table, $data);
        return true;
    }

    public function update(int $id, array $data, array $condition)
    {
        $tableName = $this->table;
        $result = $this->db->update(User::class, $data, $condition, $tableName);
        if ($result == null) {
            return null;
        }

        return $result;
    }

    public function delete(int $id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function getAll()
    {
        return null;
    }

    public function get(array $condition)
    {
        if (!empty($condition) && key($condition) !== key(array_keys($condition))) {
            $condition = array_combine(array_map(function($key) { return "$key"; }, array_keys($condition)), $condition);
        }
        return json_encode($this->db->select(User::class, null, $condition, $this->table));
    }

    public function getById(int $id)
    {
        return $this->db->select(User::class, null, ["id" => $id], $this->table);
    }

    public function getWithOffsetLimit(int $offset, int $limit, string $sort, string $orderby, string $search = null)
    {
        return $this->db->query("SELECT id, firstname, lastname, phone, birth, birth_number, city, street, psc, username, email, role FROM $this->table
        WHERE 
        id LIKE '%$search%' OR
        firstname LIKE '%$search%' OR
        lastname LIKE '%$search%' OR
        phone LIKE '%$search%' OR
        birth LIKE '%$search%' OR
        birth_number LIKE '%$search%' OR
        city LIKE '%$search%' OR
        street LIKE '%$search%' OR
        psc LIKE '%$search%' OR
        username LIKE '%$search%' OR
        email LIKE '%$search%' OR
        role LIKE '%$search%'
        ORDER BY $orderby $sort
        LIMIT $limit OFFSET $offset", [])->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserRole($username)
    {
        $userrole = $this->db->select(User::class, null, ["username" => $username], $this->table);
        return $userrole[0]->role;
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    public function getByUsername($username): ?User
    {
        $user = $this->db->select(User::class, null, ["username" => $username], $this->table);

        if (!$user) {
            return null;
        }

        $this->id = $user[0]->id;
        $this->firstname = $user[0]->firstname;
        $this->lastname = $user[0]->lastname;
        $this->phone = $user[0]->phone;
        $this->birth = $user[0]->birth;
        $this->birth_number = $user[0]->birth_number;
        $this->city = $user[0]->city;
        $this->street = $user[0]->street;
        $this->psc = $user[0]->psc;
        $this->username = $user[0]->username;
        $this->password = $user[0]->password;
        $this->email = $user[0]->email;
        $this->role = $user[0]->role;

        $this->user = $user[0];
        return $this->user;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'birth' => $this->birth,
            'birth_number' => $this->birth_number,
            'city' => $this->city,
            'street' => $this->street,
            'psc' => $this->psc,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role
        ];
    }
}
