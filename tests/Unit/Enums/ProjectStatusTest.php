<?php

namespace Tests\Unit\Enums;

use App\Enums\ProjectStatus;
use PHPUnit\Framework\TestCase;

class ProjectStatusTest extends TestCase
{
    public function test_project_status_has_correct_values(): void
    {
        $this->assertEquals('draft', ProjectStatus::DRAFT->value);
        $this->assertEquals('active', ProjectStatus::ACTIVE->value);
        $this->assertEquals('completed', ProjectStatus::COMPLETED->value);
    }

    public function test_project_status_returns_correct_labels(): void
    {
        $this->assertEquals('Draft', ProjectStatus::DRAFT->label());
        $this->assertEquals('Active', ProjectStatus::ACTIVE->label());
        $this->assertEquals('Completed', ProjectStatus::COMPLETED->label());
    }

    public function test_project_status_returns_correct_colors(): void
    {
        $this->assertEquals('gray', ProjectStatus::DRAFT->color());
        $this->assertEquals('blue', ProjectStatus::ACTIVE->color());
        $this->assertEquals('green', ProjectStatus::COMPLETED->color());
    }

    public function test_project_status_can_be_created_from_string(): void
    {
        $status = ProjectStatus::from('active');
        $this->assertInstanceOf(ProjectStatus::class, $status);
        $this->assertEquals(ProjectStatus::ACTIVE, $status);
    }

    public function test_all_project_statuses_exist(): void
    {
        $cases = ProjectStatus::cases();
        $this->assertCount(3, $cases);
        
        $values = array_map(fn($case) => $case->value, $cases);
        $this->assertContains('draft', $values);
        $this->assertContains('active', $values);
        $this->assertContains('completed', $values);
    }
}
