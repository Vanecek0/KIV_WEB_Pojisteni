<?php

namespace App\DTO;

class RegisterFormDTO
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $phone,
        public readonly string $email,
        public readonly string $birth,
        public readonly string $birth_number,
        public readonly string $city,
        public readonly string $street,
        public readonly string $psc,
        public readonly string $username,
        public readonly string $password
    ) {}
}