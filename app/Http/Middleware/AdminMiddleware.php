<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        if (! $request->user()) {
            return redirect()->route('admin.login');
        }

        if ($request->user()->status !== 'active') {
            abort(403, 'Akun Anda tidak aktif.');
        }

        if (! $request->user()->role) {
            abort(403, 'Akun Anda belum memiliki role.');
        }

        if (! $request->user()->role->is_active) {
            abort(403, 'Role akun Anda tidak aktif.');
        }

        return $next($request);
    }
}