<?php

namespace Tests\Unit\Enums;

use App\Enums\TaskPriority;
use PHPUnit\Framework\TestCase;

class TaskPriorityTest extends TestCase
{
    public function test_task_priority_has_correct_values(): void
    {
        $this->assertEquals('low', TaskPriority::LOW->value);
        $this->assertEquals('medium', TaskPriority::MEDIUM->value);
        $this->assertEquals('high', TaskPriority::HIGH->value);
    }

    public function test_task_priority_returns_correct_labels(): void
    {
        $this->assertEquals('Low', TaskPriority::LOW->label());
        $this->assertEquals('Medium', TaskPriority::MEDIUM->label());
        $this->assertEquals('High', TaskPriority::HIGH->label());
    }

    public function test_task_priority_returns_correct_colors(): void
    {
        $this->assertEquals('gray', TaskPriority::LOW->color());
        $this->assertEquals('yellow', TaskPriority::MEDIUM->color());
        $this->assertEquals('red', TaskPriority::HIGH->color());
    }

    public function test_task_priority_can_be_created_from_string(): void
    {
        $priority = TaskPriority::from('medium');
        $this->assertInstanceOf(TaskPriority::class, $priority);
        $this->assertEquals(TaskPriority::MEDIUM, $priority);
    }

    public function test_all_task_priorities_exist(): void
    {
        $cases = TaskPriority::cases();
        $this->assertCount(3, $cases);
        
        $values = array_map(fn($case) => $case->value, $cases);
        $this->assertContains('low', $values);
        $this->assertContains('medium', $values);
        $this->assertContains('high', $values);
    }
}
