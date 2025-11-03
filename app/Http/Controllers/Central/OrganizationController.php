<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function __construct(
        protected TenantService $tenantService
    ) {}

    /**
     * Display dashboard with user's organizations
     */
    public function index()
    {
        $tenants = $this->tenantService->getUserTenants(Auth::user());
        return view('central.organizations.index', compact('tenants'));
    }

    /**
     * Show form to create organization
     */
    public function create()
    {
        return view('central.organizations.create');
    }

    /**
     * Store a new organization
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tenant = $this->tenantService->createTenant($validated, Auth::user());

        return redirect()->route('organizations.index')
            ->with('success', 'Organization created successfully!');
    }

    /**
     * Switch to a specific organization
     */
    public function switch(string $tenantId)
    {
        $user = Auth::user();
        
        if (!$user->hasAccessToTenant($tenantId)) {
            abort(403, 'You do not have access to this organization.');
        }

        // Redirect to tenant context
        return redirect()->route('tenant.dashboard', ['tenant' => $tenantId]);
    }
}
