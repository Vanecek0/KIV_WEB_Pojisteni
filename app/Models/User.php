<?php
namespace App\Models;

class User {

    private int $id;
    private string $firstname;
    private string $lastname;
    private string $username;
    private string $email;
    private string $phone;
    private string $password;

    // 0 => not logged in, 1 => user, 1<<1 => admin, 1<<2 => superadmin
    private int $role;

    public function __construct() {
    }


}