<?php

namespace Tests\Unit\DTOs;

use App\DTO\ProjectData;
use App\Enums\ProjectStatus;
use PHPUnit\Framework\TestCase;

class ProjectDataTest extends TestCase
{
    public function test_can_create_project_data_from_array(): void
    {
        $data = [
            'name' => 'Test Project',
            'description' => 'Test Description',
            'status' => 'active',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
        ];

        $projectData = ProjectData::fromArray($data);

        $this->assertInstanceOf(ProjectData::class, $projectData);
        $this->assertEquals('Test Project', $projectData->name);
        $this->assertEquals('Test Description', $projectData->description);
        $this->assertEquals(ProjectStatus::ACTIVE, $projectData->status);
        $this->assertEquals('2025-01-01', $projectData->start_date);
        $this->assertEquals('2025-12-31', $projectData->end_date);
    }

    public function test_can_create_project_data_with_nullable_fields(): void
    {
        $data = [
            'name' => 'Minimal Project',
            'status' => 'draft',
        ];

        $projectData = ProjectData::fromArray($data);

        $this->assertEquals('Minimal Project', $projectData->name);
        $this->assertEquals(ProjectStatus::DRAFT, $projectData->status);
        $this->assertNull($projectData->description);
        $this->assertNull($projectData->start_date);
        $this->assertNull($projectData->end_date);
    }

    public function test_project_data_converts_status_string_to_enum(): void
    {
        $data = [
            'name' => 'Project',
            'status' => 'completed',
        ];

        $projectData = ProjectData::fromArray($data);

        $this->assertInstanceOf(ProjectStatus::class, $projectData->status);
        $this->assertEquals(ProjectStatus::COMPLETED, $projectData->status);
    }
}
