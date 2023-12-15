<?php
namespace App\Models;

class Role {
    //Základní oprávnění
    const PERM_R = 1 << 0; //1
    const PERM_W = 1 << 1; //2
    const PERM_E = 1 << 2; //4
    const PERM_D = 1 << 3; //8

    //Rozšířená oprávnění
    const PERM_U_E_D = 1 << 4; //16
    const PERM_A_E_D = 1 << 5; //32

    //Role
    const ROLE_USER = self::PERM_R; //1
    const ROLE_EDITOR = self::ROLE_USER | self::PERM_W | self::PERM_E | self::PERM_D; //15
    const ROLE_ADMIN = self::ROLE_EDITOR | self::PERM_U_E_D; //31
    const ROLE_SUPERADMIN = self::ROLE_ADMIN | self::PERM_A_E_D; //63

    public static function getRoleByValue($value) {
        $roles = self::getRoles();
        return array_search($value, $roles);
    }

    public static function getRoles() {
        return array(
            'ROLE_USER' => self::ROLE_USER, 
            'ROLE_EDITOR' => self::ROLE_EDITOR, 
            'ROLE_ADMIN' => self::ROLE_ADMIN,
            'ROLE_SUPERADMIN' => self::ROLE_SUPERADMIN
        );
    }
}