<?php

namespace App\DTO;

use App\Enums\ProjectStatus;

class ProjectData
{
    public function __construct(
        public readonly string $name,
        public readonly ?string $description = null,
        public readonly ?string $start_date = null,
        public readonly ?string $end_date = null,
        public readonly ProjectStatus $status = ProjectStatus::DRAFT,
        public readonly ?string $tenant_id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'] ?? null,
            start_date: $data['start_date'] ?? null,
            end_date: $data['end_date'] ?? null,
            status: isset($data['status']) ? ProjectStatus::from($data['status']) : ProjectStatus::DRAFT,
            tenant_id: $data['tenant_id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status->value,
            'tenant_id' => $this->tenant_id,
        ], fn($value) => $value !== null);
    }
}
