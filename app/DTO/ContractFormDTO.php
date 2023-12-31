<?php

namespace App\DTO;

class ContractFormDTO
{
    public function __construct(
        public readonly int $client_id,
        public int $vehicle_id,
        public readonly string $type,
        public readonly string $price,
        public readonly string $valid_from,
        public readonly string $valid_to,
        public readonly string $notes,
    ) {
    }

    public function toArray(): array
    {
        return [
            'client_id' => $this->client_id,
            'vehicle_id' => $this->vehicle_id,
            'type' => $this->type,
            'price' => $this->price,
            'valid_from' => $this->valid_from,
            'valid_to' => $this->valid_to,
            'notes' => $this->notes,
        ];
    }
}
