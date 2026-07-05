<?php

namespace Modules\Dashboard\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'Unauthorized. Please login to access the admin area.');
        }

        // Only allow super admins to access core admin management routes (users, roles, settings, module-builder)
        $adminOnlyPatterns = [
            'admin/users*',
            'admin/roles*',
            'admin/settings*',
            'admin/module-builder*'
        ];

        foreach ($adminOnlyPatterns as $pattern) {
            if ($request->is($pattern) && !auth()->user()->is_admin) {
                abort(403, 'Unauthorized access.');
            }
        }

        return $next($request);
    }
}
