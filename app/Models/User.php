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

    public User $user;
    public Session $session;

    private int $role;
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

    public function getWithOffsetLimit(int $offset, int $limit, string $sort, string $orderby, string $search = null)
    {
        if ($this->hasAccess((array)$this->getUserFromSession(), Role::ROLE_ADMIN)) {
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
        return false;
    }

    public function getUserRole($username)
    {
        $userrole = $this->db->select(User::class, ["username=" => $username], $this->table);
        return $userrole[0]->role;
    }

    public function updateUserRole($user, $newRole)
    {
        $requiredPermission = Role::ROLE_SUPERADMIN;
        if ($this->hasAccess((array)$user, $requiredPermission)) {
            return 'ano';
        }
        return 'ne';
        //return $this->db->update(User::class, ['role' => $newRole], ['user' => $username]);
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
        $user = $this->db->select(User::class, ["username=" => $username], $this->table);

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

    public function hasRequiredRole($requiredRole)
    {
        if (!$this->user->role == $requiredRole) {
            return false;
        }
        return true;
    }

    public function hasAccess(array $userSession, $action): bool
    {
        if (isset($userSession['role'])) {
            $userRole = (int)$userSession['role'];
            return ($userRole & $action) === $action;
        }
        return false;
    }

    private function getUserFromSession()
    {
        return $this->session->get('user') ? json_decode($this->session->get('user')) : null;
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
