<?php

namespace App\DTO;

class InsuranceEventFormDTO
{
    public function __construct(
        public ?int $id,
        public readonly int $contract_id,
        public readonly string $accident_datetime,
        public readonly string $accident_place,
        public readonly string $accident_description,
        public readonly int $estimated_damage_amount,
        public readonly string $culprit_firstname,
        public readonly string $culprit_lastname,
        public readonly string $culprit_phone,
        public readonly string $culprit_email,
        public readonly string $culprit_city,
        public readonly string $culprit_street,
        public readonly string $culprit_psc,
        public readonly string $culprit_spz,
        public readonly string $culprit_vehicle,
        public readonly string $culprit_insurance,
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'contract_id' => $this->contract_id,
            'accident_datetime' => $this->accident_datetime,
            'accident_place' => $this->accident_place,
            'accident_description' => $this->accident_description,
            'estimated_damage_amount' => $this->estimated_damage_amount,
            'culprit_firstname' => $this->culprit_firstname,
            'culprit_lastname' => $this->culprit_lastname,
            'culprit_phone' => $this->culprit_phone,
            'culprit_email' => $this->culprit_email,
            'culprit_city' => $this->culprit_city,
            'culprit_street' => $this->culprit_street,
            'culprit_psc' => $this->culprit_psc,
            'culprit_spz' => $this->culprit_spz,
            'culprit_vehicle' => $this->culprit_vehicle,
            'culprit_insurance' => $this->culprit_insurance,
        ];
    }
}
