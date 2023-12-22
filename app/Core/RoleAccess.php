<?php

namespace App\Core;

class RoleAccess
{
    public Session $session;
    public FlashMessage $flashMessage;
    private static ?RoleAccess $instance = null;

    public static function getInstance(): RoleAccess
    {
        return self::$instance ??= new RoleAccess();
    }

    public function __construct()
    {
        $this->session = Session::getInstance();
        $this->flashMessage = new FlashMessage();
    }

    public function hasAccess($requiredRole): bool
    {
        if ($this->hasRequiredRole($requiredRole)) {
            $userRole = (int)$this->getUserRole();
            return ($userRole & $requiredRole) === $requiredRole;
        }
        return false;
    }

    public function hasRequiredRole($requiredRole)
    {
        if ($this->getUserRole() != $requiredRole) {
            return false;
        }
        return true;
    }

    public function getUserRole():string {
        return $this->session->getAsArray('user')['role'];
    }
}