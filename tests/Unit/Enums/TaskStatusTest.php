<?php

namespace Tests\Unit\Enums;

use App\Enums\TaskStatus;
use PHPUnit\Framework\TestCase;

class TaskStatusTest extends TestCase
{
    public function test_task_status_has_correct_values(): void
    {
        $this->assertEquals('todo', TaskStatus::TODO->value);
        $this->assertEquals('in_progress', TaskStatus::IN_PROGRESS->value);
        $this->assertEquals('done', TaskStatus::DONE->value);
    }

    public function test_task_status_returns_correct_labels(): void
    {
        $this->assertEquals('To Do', TaskStatus::TODO->label());
        $this->assertEquals('In Progress', TaskStatus::IN_PROGRESS->label());
        $this->assertEquals('Done', TaskStatus::DONE->label());
    }

    public function test_task_status_returns_correct_colors(): void
    {
        $this->assertEquals('gray', TaskStatus::TODO->color());
        $this->assertEquals('blue', TaskStatus::IN_PROGRESS->color());
        $this->assertEquals('green', TaskStatus::DONE->color());
    }

    public function test_task_status_can_be_created_from_string(): void
    {
        $status = TaskStatus::from('todo');
        $this->assertInstanceOf(TaskStatus::class, $status);
        $this->assertEquals(TaskStatus::TODO, $status);
    }

    public function test_all_task_statuses_exist(): void
    {
        $cases = TaskStatus::cases();
        $this->assertCount(3, $cases);
        
        $values = array_map(fn($case) => $case->value, $cases);
        $this->assertContains('todo', $values);
        $this->assertContains('in_progress', $values);
        $this->assertContains('done', $values);
    }
}
