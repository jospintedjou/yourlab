<?php

namespace App\DTO;

class TaskData
{
    public function __construct(
        public readonly int $project_id,
        public readonly string $title,
        public readonly ?string $description = null,
        public readonly string $status = 'todo',
        public readonly ?string $priority = null,
        public readonly ?string $due_date = null,
        public readonly ?int $assigned_to = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            project_id: $data['project_id'],
            title: $data['title'],
            description: $data['description'] ?? null,
            status: $data['status'] ?? 'todo',
            priority: $data['priority'] ?? null,
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
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date,
            'assigned_to' => $this->assigned_to,
        ];
    }
}
