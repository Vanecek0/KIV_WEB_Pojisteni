<?php
namespace App\Models;

use App\Core\Database;
use App\Interfaces\IDBmodel;
use JsonSerializable;

class User implements IDBmodel, JsonSerializable{

    public int $id;
    public string $username;
    public string $email;
    public string $password;

    // 0 => not logged in, 1 => user, 1<<1 => admin, 1<<2 => superadmin
    private int $role;
    private Database $db;
    protected $usersTable = 'users';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function create(array $data) {

        $existingUser = $this->getByUsername($data['username']);
        if ($existingUser) {
            return false;
        }
        return $this->db->insert($this->usersTable, $data);
    }

    public function update(int $id, array $data)
    {
        return null;
    }

    public function delete(int $id)
    {
        return null;
    }

    public function getAll() {
        return null;
    }

    public function getById(int $id)
    {
        return null;
    }

    public function getByUsername($username) {
        $user = $this->db->select(User::class, ["username=" => $username], $this->usersTable);
        
        if(!$user) { 
            return false;
        }

        $this->id = $user[0]->id;
        $this->username = $user[0]->username;
        $this->password = $user[0]->password;
        $this->email = $user[0]->email;
        $this->role = $user[0]->role;

        return $user[0];
    }

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role
        ];
    }

}