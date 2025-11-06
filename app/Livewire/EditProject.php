<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ProjectService;
use App\Models\Project;
use App\Enums\ProjectStatus;
use App\DTO\ProjectData;
use Illuminate\Validation\Rule;

class EditProject extends Component
{
    public $projectId;
    public $name = '';
    public $description = '';
    public $start_date = '';
    public $end_date = '';
    public $status = 'draft';
    public $tenantId;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => ['required', Rule::enum(ProjectStatus::class)],
        ];
    }

    public function mount($projectId)
    {
        $this->tenantId = tenant('id');
        $this->projectId = $projectId;
        
        $project = Project::findOrFail($projectId);
        $this->name = $project->name;
        $this->description = $project->description;
        $this->start_date = $project->start_date ? $project->start_date->format('Y-m-d') : '';
        $this->end_date = $project->end_date ? $project->end_date->format('Y-m-d') : '';
        $this->status = $project->status->value;
    }

    public function update(ProjectService $projectService)
    {
        $validated = $this->validate();
        
        // Explicitly add tenant_id for single database multi-tenancy
        $validated['tenant_id'] = $this->tenantId;
        
        $project = Project::findOrFail($this->projectId);
        $projectData = ProjectData::fromArray($validated);
        $projectService->updateProject($project, $projectData);

        session()->flash('success', 'Projet mis à jour avec succès !');
        
        return redirect()->route('tenant.projects.index', ['tenant' => $this->tenantId]);
    }

    public function render()
    {
        return view('livewire.edit-project', [
            'statuses' => ProjectStatus::cases()
        ]);
    }
}
