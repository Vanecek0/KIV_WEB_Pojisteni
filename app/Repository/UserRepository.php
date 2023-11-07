<?php
namespace App\Repository;

use App\Models\User;

class UserRepository extends Repository {
    
    public function find(int $id):?User {

        $result = $this->getDatabase()->select(User::class, ['id =' => $id]);
        if(empty($result)) {
            return null;
        }

        return $result[0];
    }
}