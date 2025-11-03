<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTenantAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!tenancy()->initialized) {
            return $next($request);
        }

        $tenantId = tenant('id');
        $user = Auth::user();

        if (!$user || !$user->hasAccessToTenant($tenantId)) {
            abort(403, 'You do not have access to this organization.');
        }

        return $next($request);
    }
}
