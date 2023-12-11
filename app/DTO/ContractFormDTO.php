<?php

namespace App\DTO;

class ContractFormDTO
{
    public function __construct(
        public readonly string $vehicle,
        public readonly string $spz,
        public readonly string $vin,
        public readonly string $insurer,
        public readonly string $ico,
        public readonly string $dic,
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $birth,
        public readonly string $birth_number,
        public readonly string $phone_number,
        public readonly string $email,
        public readonly string $city,
        public readonly string $street,
        public readonly string $psc,
        public readonly string $car_photos,
        public readonly string $type
    ) {
    }

    public function toArray(): array
    {
        return [
            'vehicle' => $this->vehicle,
            'spz' => $this->spz,
            'vin' => $this->vin,
            'insurer' => $this->insurer,
            'ico' => $this->ico,
            'dic' => $this->dic,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'birth' => $this->birth,
            'birth_number' => $this->birth_number,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'city' => $this->city,
            'street' => $this->street,
            'psc' => $this->psc,
            'car_photos' => $this->car_photos,
            'type' => $this->type
        ];
    }
}
