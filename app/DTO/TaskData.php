<?php

namespace App\DTO;

use App\Enums\TaskStatus;
use App\Enums\TaskPriority;

class TaskData
{
    public function __construct(
        public readonly int $project_id,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly TaskStatus $status = TaskStatus::TODO,
        public readonly ?TaskPriority $priority = null,
        public readonly ?string $due_date = null,
        public readonly ?int $assigned_to = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            project_id: $data['project_id'],
            title: $data['title'],
            description: $data['description'] ?? null,
            status: isset($data['status']) ? TaskStatus::from($data['status']) : TaskStatus::TODO,
            priority: isset($data['priority']) ? TaskPriority::from($data['priority']) : null,
            due_date: $data['due_date'] ?? null,
            assigned_to: $data['assigned_to'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'project_id' => $this->project_id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'priority' => $this->priority?->value,
            'due_date' => $this->due_date,
            'assigned_to' => $this->assigned_to,
        ];
    }
}
