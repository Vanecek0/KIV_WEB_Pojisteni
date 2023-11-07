<?php
namespace App\Repository;

use App\Core\Database;

abstract class Repository {

    protected Database $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getDatabase() {
        return $this->db;
    }
}