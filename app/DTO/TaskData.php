<?php

namespace App\DTO;

use App\Enums\TaskStatus;
use App\Enums\TaskPriority;

class TaskData
{
    public function __construct(
        public readonly ?int $project_id,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly TaskStatus $status = TaskStatus::TODO,
        public readonly ?TaskPriority $priority = null,
        public readonly ?string $due_date = null,
        public readonly ?int $assigned_to = null,
        public readonly ?string $tenant_id = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            project_id: $data['project_id'] ?? null,
            title: $data['title'],
            description: $data['description'] ?? null,
            status: isset($data['status']) ? TaskStatus::from($data['status']) : TaskStatus::TODO,
            priority: isset($data['priority']) ? TaskPriority::from($data['priority']) : null,
            due_date: $data['due_date'] ?? null,
            assigned_to: isset($data['assigned_to']) ? (int) $data['assigned_to'] : null,
            tenant_id: $data['tenant_id'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'project_id' => $this->project_id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'priority' => $this->priority?->value,
            'due_date' => $this->due_date,
            'assigned_to' => $this->assigned_to,
            'tenant_id' => $this->tenant_id,
        ], fn($value, $key) => $value !== null || $key === 'assigned_to', ARRAY_FILTER_USE_BOTH);
    }
}
