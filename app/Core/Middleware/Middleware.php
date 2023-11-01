<?php
namespace App\Core\Middleware;

class Middleware {
    const MAP = [
        'auth_only' => Auth::class,
        'guest_only' => Guest::class
    ];

    public static function resolve(string $key, string $redirect = null) {
        if($key === '') {
            return false;
        }

        $middleware = static::MAP[$key];
        (new $middleware)->handle($redirect);
    }
}