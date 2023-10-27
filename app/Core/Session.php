<?php

namespace App\Core;

class Session
{
    private static ?Session $instance = null;

    private function __construct()
    {
        session_start();
    }

    public static function getInstance(): Session
    {
        return self::$instance ??= new Session();
    }

    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : false;
    }

    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    public function removeSession($session) {
        unset($session);
    }

}
