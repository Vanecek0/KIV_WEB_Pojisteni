<?php

namespace App\API;
use App\Core\Request;
use App\Models\Role;

class Roles
{
    private UserModel $usermodel;

    public function __construct()
    {
        header('Content-type: application/json');
    }

    public function getAll(Request $req)
    {
        return json_encode(Role::getRoles());
    }

    public function getRoleByValue(Request $req) {
        if( $req->getParam('role') != null ) {
            return json_encode(Role::getRoleByValue($req->getParam('role')));
        }
        return false;
    }
}