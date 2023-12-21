<?php

namespace App\API;

use App\Core\Request;
use App\Models\Contract as ContractModel;

class Contracts
{
    private ContractModel $contractmodel;

    public function __construct()
    {
        header('Content-type: application/json');
        $this->contractmodel = new ContractModel();
    }

    public function fetchAll(Request $req)
    {

        if (($req->getParam('offset') != null && $req->getParam('limit') != null)) {
            $response = json_encode($this->contractmodel->getWithOffsetLimit($req->getParam('offset'), $req->getParam('limit'), $req->getParam('sort'), $req->getParam('orderby'), $req->getParam('search')));
            return ($response);
        }
        return false;
    }

    public function get(Request $req) {
        if($req->getAllParams() != null) {
            return $this->contractmodel->get(array_slice($req->getAllParams(), 2));
        }
    }

    public function update(Request $req)
    {
        if ($req->getParam('id') != null) {
            return $this->contractmodel->update($req->getParam('id'), array_slice($req->getAllParams(), 2));
        }
        return false;
    }

    public function delete(Request $req)
    {
        if ($req->getParam('id') != null) {
            return $this->contractmodel->delete($req->getParam('id'));
        }
        return false;
    }
}