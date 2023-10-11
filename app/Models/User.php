<?php
namespace App\Models;

use App\Core\Database;

class User {

    public int $id;
    public string $username;
    public string $email;
    private string $password;

    // 0 => not logged in, 1 => user, 1<<1 => admin, 1<<2 => superadmin
    private int $role;
    private $db;
    private $usersTable = 'users';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getUserByUsername($username) {
        return $this->db->select(User::class, ["username=" => $username], $this->usersTable);
    }

}