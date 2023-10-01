<?php

namespace App\Core;

use PDO;
use PDOStatement;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;

    private function __construct()
    {
    }

    public static function getInstance(): Database
    {
        return self::$instance ??= new Database();
    }

    public function query(string $query, array $params = []):?PDOStatement
    {
        $stmt = $this->pdo->prepare($query);
        array_walk(
            $params,
            function ($value, $key) use ($stmt) {
                $stmt->bindValue($key+1, $value);
            }
        );

        if(!$stmt->execute()) {
            return null;
        }

        return $stmt;
    }

    public function select(string $class, array $where=[]) {
        $lowerClass = strtolower($class);
        $sql = "SELECT * FROM $lowerClass";

        if(!empty($where)) {
            $sql .= " WHERE ";
            $keys = array_map(fn ($key) => $key . " ?", array_keys($where));
            $sql .= join(", ", $keys);
            
        }
        $values = array_values($where);
        $result = $this->query($sql, $values);

        if($result == null) {
            return [];
        }

        return $result->fetchAll(PDO::FETCH_CLASS, $class);
    }
}