<?php

namespace App\Core;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
    private static ?Database $instance = null;
    private PDO $pdo;
    private string $dbuser = 'root';
    private string $dbpass = '';

    private function __construct()
    {
        $this->connect();
    }

    public static function getInstance(): Database
    {
        return self::$instance ??= new Database();
    }

    public function connect(): PDO
    {
        try {
            $this->pdo = new PDO('mysql:host=127.0.0.1:3307;dbname=carinsurance', $this->dbuser, $this->dbpass);
            return $this->pdo;
        } catch (PDOException $e) {
            error_log('Database connection error: ' . $e->getMessage());
            throw new \Exception('Unable to connect to the database.');
        }
    }

    public function query(string $query, array $params = []): ?PDOStatement
    {
        $stmt = $this->pdo->prepare($query);
        array_walk(
            $params,
            function ($value, $key) use ($stmt) {
                $stmt->bindValue($key + 1, $value);
            }
        );

        if (!$stmt->execute()) {
            return null;
        }

        return $stmt;
    }

    public function select(string $class, array $where = [], string $tableName = null)
    {
        $tableName = $tableName ?? strtolower($class);
        $sql = "SELECT * FROM $tableName";


        if (!empty($where)) {
            $sql .= " WHERE ";
            $keys = array_map(fn ($key) => $key . " ?", array_keys($where));
            $sql .= join(", ", $keys);
        }

        $values = array_values($where);
        $result = $this->query($sql, $values);


        if ($result == null) {
            return [];
        }

        return $result->fetchAll(PDO::FETCH_CLASS, $class);
    }

    public function insert(string $tableName, array $data): ?int
    {
        $columns = implode(', ', array_keys($data));
        $values = implode(', ', array_fill(0, count($data), '?'));
        $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";

        $result = $this->query($sql, array_values($data));

        if ($result == null) {
            return null;
        }

        return $this->pdo->lastInsertId();
    }

    public function update(string $class, array $data, array $condition, string $tableName = null): ?int
    {
        $tableName = $tableName ?? strtolower($class);
        $setClause = implode(', ', array_map(fn ($column) => "$column = ?", array_keys($data)));
        $conditionClause = implode(' AND ', array_map(fn ($column) => "$column = ?", array_keys($condition)));

        $sql = "UPDATE $tableName SET $setClause WHERE $conditionClause";

        $result = $this->query($sql, array_merge(array_values($data), array_values($condition)));

        if ($result == null) {
            return null;
        }

        return $result->rowCount();
    }

    public function delete(string $tableName, array $condition): ?int
    {
        $conditionClause = implode(' AND ', array_map(fn ($column) => "$column = ?", array_keys($condition)));
        $sql = "DELETE FROM $tableName WHERE $conditionClause";

        $result = $this->query($sql, array_values($condition));

        if ($result == null) {
            return null;
        }

        return $result->rowCount();
    }
}
