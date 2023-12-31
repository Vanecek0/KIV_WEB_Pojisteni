<?php

namespace App\API;

use App\Core\Request;
use App\Models\User as UserModel;
use App\Models\Role;
use App\Core\RoleAccess;
use App\Core\FlashMessage;

class Users
{
    private UserModel $usermodel;
    private RoleAccess $roleaccess;
    private FlashMessage $flashmessage;

    public function __construct()
    {
        header('Content-type: application/json');
        $this->usermodel = new UserModel();
        $this->roleaccess = RoleAccess::getInstance();
        $this->flashmessage = new FlashMessage();
    }

    public function fetchAll(Request $req)
    {
        if ($this->roleaccess->hasAccess(Role::ROLE_ADMIN) && ($req->getParam('offset') != null && $req->getParam('limit') != null)) {
            return json_encode($this->usermodel->getWithOffsetLimit($req->getParam('offset'), $req->getParam('limit'), $req->getParam('sort'), $req->getParam('orderby'), $req->getParam('search')));
        }
        return false;
    }

    public function get(Request $req) {
        if($this->roleaccess->hasAccess(Role::ROLE_ADMIN) && $req->getAllParams() != null) {
            return $this->usermodel->get(array_slice($req->getAllParams(), 2));
        }
        return false;
    }

    public function update(Request $req)
    {
        if (!$this->roleaccess->hasAccess(Role::ROLE_ADMIN)) {
            $this->flashmessage->setFlashMessage("message", "Pro provedení této akce nemáte dostatečná oprávnění");
            return $this->flashmessage->getMessagesArray();
        }

        $userId = $req->getParam('id');
        if ($userId === null) {
            return false;
        }

        $selectedUser = $this->usermodel->getById($userId);
        if ($this->roleaccess->getUserRole() <= $selectedUser[0]->role || $this->roleaccess->getUserRole() <= $req->getParam('role')) {
            $this->flashmessage->setFlashMessage("message", "Pro provedení této akce nemáte dostatečná oprávnění");
            return $this->flashmessage->getMessagesArray();
        }

        $update = $this->usermodel->update($userId, array_slice($req->getAllParams(), 2), $req->getParamAsArray('id'));
        
        if ($update) {
            $this->flashmessage->setFlashMessage("message", "Změny úspěšně uloženy");
            return $this->flashmessage->getMessagesArray();
        }

        return true;
    }

    public function delete(Request $req)
    {
        if ($this->roleaccess->hasAccess(Role::ROLE_ADMIN) && $req->getParam('id') != null) {
            return $this->usermodel->delete($req->getParam('id'));
        }
        return false;
    }
}