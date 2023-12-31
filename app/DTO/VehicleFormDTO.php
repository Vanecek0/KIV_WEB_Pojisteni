<?php

namespace App\DTO;

class VehicleFormDTO
{
    public function __construct(
        public ?int $id,
        public readonly string $user_id,
        public readonly string $brand,
        public readonly string $model,
        public readonly string $engine_power,
        public readonly string $engine_capacity,
        public readonly string $fuel_type,
        public readonly string $manufacture_year,
        public readonly string $registration_date,
        public readonly string $vin,
        public readonly string $spz
    ) {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'brand' => $this->brand,
            'model' => $this->model,
            'engine_power' => $this->engine_power,
            'engine_capacity' => $this->engine_capacity,
            'fuel_type' => $this->fuel_type,
            'manufacture_year' => $this->manufacture_year,
            'registration_date' => $this->registration_date,
            'vin' => $this->vin,
            'spz' => $this->spz
        ];
    }
}
