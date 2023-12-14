<?php

namespace App\API;

use App\Core\Request;
use App\Models\User as UserModel;

class Users
{
    private UserModel $usermodel;

    public function __construct()
    {
        header('Content-type: application/json');
        $this->usermodel = new UserModel();
    }

    public function fetchAll(Request $req)
    {

        if (($req->getParam('offset') != null && $req->getParam('limit') != null)) {
            $response = json_encode($this->usermodel->getWithOffsetLimit($req->getParam('offset'), $req->getParam('limit'), $req->getParam('sort'), $req->getParam('orderby'), $req->getParam('search')));
            return ($response);
        }
        return false;
    }

    public function get(Request $req) {
        if($req->getAllParams() != null) {
            return $this->usermodel->get(array_slice($req->getAllParams(), 2));
        }
    }

    public function update(Request $req)
    {
        if ($req->getParam('id') != null) {
            return $this->usermodel->update($req->getParam('id'), array_slice($req->getAllParams(), 2));
        }
        return false;
    }

    public function delete(Request $req)
    {
        if ($req->getParam('id') != null) {
            return $this->usermodel->delete($req->getParam('id'));
        }
        return false;
    }
}