<?php

namespace App\DTO;

class LoginFormDTO
{

    public function __construct(
        public readonly string $username,
        public readonly string $password
    ) {}
}