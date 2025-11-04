<?php

namespace Tests\Unit\DTOs;

use App\DTO\TaskData;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;
use PHPUnit\Framework\TestCase;

class TaskDataTest extends TestCase
{
    public function test_can_create_task_data_from_array(): void
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'status' => 'todo',
            'priority' => 'high',
            'due_date' => '2025-12-31',
            'project_id' => 1,
        ];

        $taskData = TaskData::fromArray($data);

        $this->assertInstanceOf(TaskData::class, $taskData);
        $this->assertEquals('Test Task', $taskData->title);
        $this->assertEquals('Test Description', $taskData->description);
        $this->assertEquals(TaskStatus::TODO, $taskData->status);
        $this->assertEquals(TaskPriority::HIGH, $taskData->priority);
        $this->assertEquals('2025-12-31', $taskData->due_date);
        $this->assertEquals(1, $taskData->project_id);
    }

    public function test_can_create_task_data_with_nullable_fields(): void
    {
        $data = [
            'title' => 'Minimal Task',
            'status' => 'todo',
        ];

        $taskData = TaskData::fromArray($data);

        $this->assertEquals('Minimal Task', $taskData->title);
        $this->assertEquals(TaskStatus::TODO, $taskData->status);
        $this->assertNull($taskData->description);
        $this->assertNull($taskData->priority);
        $this->assertNull($taskData->due_date);
        $this->assertNull($taskData->project_id);
    }

    public function test_task_data_converts_enums_from_strings(): void
    {
        $data = [
            'title' => 'Task',
            'status' => 'in_progress',
            'priority' => 'medium',
        ];

        $taskData = TaskData::fromArray($data);

        $this->assertInstanceOf(TaskStatus::class, $taskData->status);
        $this->assertEquals(TaskStatus::IN_PROGRESS, $taskData->status);
        
        $this->assertInstanceOf(TaskPriority::class, $taskData->priority);
        $this->assertEquals(TaskPriority::MEDIUM, $taskData->priority);
    }

    public function test_task_data_handles_null_priority(): void
    {
        $data = [
            'title' => 'Task',
            'status' => 'done',
            'priority' => null,
        ];

        $taskData = TaskData::fromArray($data);

        $this->assertNull($taskData->priority);
    }
}
