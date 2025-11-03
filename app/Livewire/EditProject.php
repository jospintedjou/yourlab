<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ProjectService;
use App\Models\Project;

class EditProject extends Component
{
    public $projectId;
    public $name = '';
    public $description = '';
    public $start_date = '';
    public $end_date = '';
    public $status = 'draft';
    public $tenantId;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'nullable|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'status' => 'required|in:draft,active,completed',
    ];

    public function mount($projectId)
    {
        $this->tenantId = tenant('id');
        $this->projectId = $projectId;
        
        $project = Project::findOrFail($projectId);
        $this->name = $project->name;
        $this->description = $project->description;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;
        $this->status = $project->status;
    }

    public function update(ProjectService $projectService)
    {
        $validated = $this->validate();
        
        $projectService->updateProject($this->projectId, $validated);

        session()->flash('success', 'Project updated successfully!');
        
        return redirect()->route('tenant.projects.index', ['tenant' => $this->tenantId]);
    }

    public function render()
    {
        return view('livewire.edit-project');
    }
}
