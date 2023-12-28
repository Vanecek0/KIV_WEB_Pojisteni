<?php

namespace App\API;

use App\Core\Request;
use App\Core\RoleAccess;
use App\Core\FlashMessage;
use App\Models\InsuranceEvent as InsuraceEventModel;
use App\Models\Role;

class InsuranceEvents
{
    private InsuraceEventModel $insurancemodel;
    private RoleAccess $roleaccess;
    private FlashMessage $flashmessage;

    public function __construct()
    {
        header('Content-type: application/json');
        $this->insurancemodel = new InsuraceEventModel();
        $this->roleaccess = RoleAccess::getInstance();
        $this->flashmessage = new FlashMessage();
    }

    public function fetchAll(Request $req)
    {
        if ($this->roleaccess->hasAccess(Role::ROLE_EDITOR) && ($req->getParam('offset') != null && $req->getParam('limit') != null)) {
            $response = json_encode($this->insurancemodel->getWithOffsetLimit($req->getParam('offset'), $req->getParam('limit'), $req->getParam('sort'), $req->getParam('orderby'), $req->getParam('search')));
            return ($response);
        }
        return false;
    }

    public function get(Request $req) {
        if($this->roleaccess->hasAccess(Role::ROLE_EDITOR) && $req->getAllParams() != null) {
            return $this->insurancemodel->get(array_slice($req->getAllParams(), 2));
        }
        return false;
    }

    public function update(Request $req)
    {
        if (!$this->roleaccess->hasAccess(Role::ROLE_EDITOR)) {
            $this->flashmessage->setFlashMessage("message", "Pro provedení této akce nemáte dostatečná oprávnění");
            return $this->flashmessage->getMessagesArray();
        }

        $contractId = $req->getParam('id');
        if ($contractId === null) {
            return false;
        }

        $update = $this->insurancemodel->update($contractId, array_slice($req->getAllParams(), 2), $req->getParamAsArray('id'));
        
        if ($update) {
            $this->flashmessage->setFlashMessage("message", "Změny úspěšně uloženy");
            return $this->flashmessage->getMessagesArray();
        }

        return true;
    }

    public function delete(Request $req)
    {
        if ($req->getParam('id') != null) {
            return $this->insurancemodel->delete($req->getParam('id'));
        }
        return false;
    }


    public function getAllContstants(Request $req)
    {
        return json_encode($this->insurancemodel->getInsuranceConstants());
    }
}