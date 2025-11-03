<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ProjectService;

class CreateProject extends Component
{
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

    public function mount()
    {
        $this->tenantId = tenant('id');
    }

    public function save(ProjectService $projectService)
    {
        $validated = $this->validate();
        
        $projectService->createProject($validated);

        session()->flash('success', 'Project created successfully!');
        
        return redirect()->route('tenant.projects.index', ['tenant' => $this->tenantId]);
    }

    public function render()
    {
        return view('livewire.create-project');
    }
}
