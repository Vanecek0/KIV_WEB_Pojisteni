<?php

namespace App\Models;

use App\Core\Database;
use App\Interfaces\IDBmodel;
use JsonSerializable;

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
    public string $gdpr;
    public string $terms;

    public User $user;

    private int $role;
    private Database $db;
    protected $table = 'users';

    public function __construct()
    {
        $this->db = Database::getInstance();
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

    public function getUserRole($username)
    {
        $userrole = $this->db->select(User::class, ["username=" => $username], $this->table);
        return $userrole[0]->role;
    }

    public function updateUserRole($user, $newRole)
    {
        $requiredPermission = Role::ROLE_SUPERADMIN;
        var_dump($requiredPermission);
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
            var_dump($userRole & $action);
            return ($userRole & $action) === $action;
        }

        return false;
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
