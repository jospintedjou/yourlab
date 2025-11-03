<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class OrganizationSwitcher extends Component
{
    public $organizations;
    public $showDropdown = false;

    public function mount()
    {
        $this->organizations = Auth::user()->tenants;
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function switchOrganization($tenantId)
    {
        return redirect()->route('tenant.dashboard', ['tenant' => $tenantId]);
    }

    public function render()
    {
        return view('livewire.organization-switcher');
    }
}
