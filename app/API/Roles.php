<?php

namespace App\API;
use App\Core\Request;
use App\Models\Role as RoleModel;

class Roles
{
    private RoleModel $rolemodel;

    public function __construct()
    {
        header('Content-type: application/json');
        $this->rolemodel = new RoleModel();
    }

    public function getAll(Request $req)
    {
        return json_encode($this->rolemodel->getRoles());
    }

    public function getRoleByValue(Request $req) {
        if( $req->getParam('role') != null ) {
            return json_encode($this->rolemodel->getRoleByValue($req->getParam('role')));
        }
        return false;
    }
}