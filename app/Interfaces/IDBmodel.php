<?php
namespace App\Interfaces;

interface IDBmodel {

    public function getAll();
    public function getById(int $id);
    public function create(array $data);
    public function update(int $id, array $data, array $condition);
    public function delete(int $id);
}