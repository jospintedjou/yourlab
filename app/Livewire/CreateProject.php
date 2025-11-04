<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\ProjectService;
use App\Enums\ProjectStatus;
use App\DTO\ProjectData;
use Illuminate\Validation\Rule;

class CreateProject extends Component
{
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

    public function mount()
    {
        $this->tenantId = tenant('id');
    }

    public function save(ProjectService $projectService)
    {
        $validated = $this->validate();
        
        $projectData = ProjectData::fromArray($validated);
        $projectService->createProject($projectData);

        session()->flash('success', 'Projet créé avec succès !');
        
        return redirect()->route('tenant.projects.index', ['tenant' => $this->tenantId]);
    }

    public function render()
    {
        return view('livewire.create-project');
    }
}
