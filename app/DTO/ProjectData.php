<?php

namespace App\DTO;

class ProjectData
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly ?string $start_date = null,
        public readonly ?string $end_date = null,
        public readonly string $status = 'draft',
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            start_date: $data['start_date'] ?? null,
            end_date: $data['end_date'] ?? null,
            status: $data['status'] ?? 'draft',
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
        ];
    }
}
