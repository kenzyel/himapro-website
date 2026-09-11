<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$permissions
    ): Response {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('admin.login');
        }

        if (! $user->hasAnyPermission($permissions)) {
            abort(403, 'Anda tidak memiliki permission untuk melakukan tindakan ini.');
        }

        return $next($request);
    }
}