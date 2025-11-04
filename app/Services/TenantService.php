<?php

namespace App\Services;

use App\DTO\TenantData;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Str;

class TenantService
{
    /**
     * Create a new tenant (organization)
     */
    public function createTenant(TenantData $data, User $user): Tenant
    {
        // Create tenant
        $tenant = Tenant::create([
            'id' => Str::slug($data->name) . '-' . Str::random(6),
            'name' => $data->name,
        ]);

        // Create domain for path-based routing
        $tenant->domains()->create([
            'domain' => $tenant->id,
        ]);

        // Attach user as admin
        $tenant->users()->attach($user->id, ['role' => 'admin']);

        return $tenant;
    }

    /**
     * Add user to tenant
     */
    public function addUserToTenant(Tenant $tenant, User $user, string $role = 'member'): void
    {
        if (!$tenant->users()->where('user_id', $user->id)->exists()) {
            $tenant->users()->attach($user->id, ['role' => $role]);
        }
    }

    /**
     * Remove user from tenant
     */
    public function removeUserFromTenant(Tenant $tenant, User $user): void
    {
        $tenant->users()->detach($user->id);
    }

    /**
     * Update user role in tenant
     */
    public function updateUserRole(Tenant $tenant, User $user, string $role): void
    {
        $tenant->users()->updateExistingPivot($user->id, ['role' => $role]);
    }

    /**
     * Get all tenants for a user
     */
    public function getUserTenants(User $user)
    {
        return $user->tenants;
    }
}
