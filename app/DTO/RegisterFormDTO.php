<?php

namespace App\DTO;

class RegisterFormDTO
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $birth,
        public readonly string $address,
        public readonly bool $gdpr,
        public readonly bool $terms,
        public readonly string $username,
        public readonly string $password
    ) {}
}