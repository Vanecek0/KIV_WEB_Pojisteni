<?php

namespace App\API;

use App\Core\Request;
use App\Models\User as UserModel;

class Users
{
    private UserModel $usermodel;

    public function __construct()
    {
        $this->usermodel = new UserModel();
    }

    public function fetch(Request $req)
    {
        header('Content-type: application/json');

        if (($req->getParam('offset') != null && $req->getParam('limit') != null)) {
            $response = json_encode($this->usermodel->getWithOffsetLimit($req->getParam('offset'), $req->getParam('limit'), $req->getParam('search')));
            return ($response);
        }

        return false;
    }
}
