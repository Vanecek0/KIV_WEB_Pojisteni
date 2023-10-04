<?php
namespace App\Models;

use App\Core\Database;

class User {

    private int $id;
    public ?string $username;
    private string $email;
    private string $password;

    // 0 => not logged in, 1 => user, 1<<1 => admin, 1<<2 => superadmin
    private int $role;
    private $db;
    private $usersTable = 'users';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getUserById($userId) {
        return $this->db->select(User::class, [], $this->usersTable);
    }

}